<?php
/**
 * Blocks API: WP_Block_Type class
 *
 * @package WordPress
 * @subpackage Blocks
 * @since 5.0.0
 */

/**
 * Core class representing a block type.
 *
 * @since 5.0.0
 *
 * @see register_block_type()
 */
class WP_Block_Type
{
    /**
     * Block type key.
     *
     * @since 5.0.0
     * @var string
     */
    public $name;

    /**
     * Block type render callback.
     *
     * @since 5.0.0
     * @var callable
     */
    public $render_callback;

    /**
     * Block type attributes property schemas.
     *
     * @since 5.0.0
     * @var array
     */
    public $attributes;

    /**
     * Block type editor script handle.
     *
     * @since 5.0.0
     * @var string
     */
    public $editor_script;

    /**
     * Block type front end script handle.
     *
     * @since 5.0.0
     * @var string
     */
    public $script;

    /**
     * Block type editor style handle.
     *
     * @since 5.0.0
     * @var string
     */
    public $editor_style;

    /**
     * Block type front end style handle.
     *
     * @since 5.0.0
     * @var string
     */
    public $style;

    /**
     * Constructor.
     *
     * Will populate object properties from the provided arguments.
     *
     * @param string $block_type Block type name including namespace.
     * @param array|string $args Optional. Array or string of arguments for registering a block type.
     *                                 Default empty array.
     * @since 5.0.0
     *
     * @see register_block_type()
     *
     */
    public function __construct($block_type, $args = array())
    {
        $this->name = $block_type;

        $this->set_props($args);
    }

    /**
     * Renders the block type output for given attributes.
     *
     * @param array $attributes Optional. Block attributes. Default empty array.
     * @param string $content Optional. Block content. Default empty string.
     * @return string Rendered block type output.
     * @since 5.0.0
     *
     */
    public function render($attributes = array(), $content = '')
    {
        if (!$this->is_dynamic()) {
            return '';
        }

        $attributes = $this->prepare_attributes_for_render($attributes);

        return (string)call_user_func($this->render_callback, $attributes, $content);
    }

    /**
     * Returns true if the block type is dynamic, or false otherwise. A dynamic
     * block is one which defers its rendering to occur on-demand at runtime.
     *
     * @return boolean Whether block type is dynamic.
     * @since 5.0.0
     *
     */
    public function is_dynamic()
    {
        return is_callable($this->render_callback);
    }

    /**
     * Validates attributes against the current block schema, populating
     * defaulted and missing values.
     *
     * @param array $attributes Original block attributes.
     * @return array             Prepared block attributes.
     * @since 5.0.0
     *
     */
    public function prepare_attributes_for_render($attributes)
    {
        // If there are no attribute definitions for the block type, skip
        // processing and return vebatim.
        if (!isset($this->attributes)) {
            return $attributes;
        }

        foreach ($attributes as $attribute_name => $value) {
            // If the attribute is not defined by the block type, it cannot be
            // validated.
            if (!isset($this->attributes[$attribute_name])) {
                continue;
            }

            $schema = $this->attributes[$attribute_name];

            // Validate value by JSON schema. An invalid value should revert to
            // its default, if one exists. This occurs by virtue of the missing
            // attributes loop immediately following. If there is not a default
            // assigned, the attribute value should remain unset.
            $is_valid = rest_validate_value_from_schema($value, $schema);
            if (is_wp_error($is_valid)) {
                unset($attributes[$attribute_name]);
            }
        }

        // Populate values of any missing attributes for which the block type
        // defines a default.
        $missing_schema_attributes = array_diff_key($this->attributes, $attributes);
        foreach ($missing_schema_attributes as $attribute_name => $schema) {
            if (isset($schema['default'])) {
                $attributes[$attribute_name] = $schema['default'];
            }
        }

        return $attributes;
    }

    /**
     * Sets block type properties.
     *
     * @param array|string $args Array or string of arguments for registering a block type.
     * @since 5.0.0
     *
     */
    public function set_props($args)
    {
        $args = wp_parse_args(
            $args,
            array(
                'render_callback' => null,
            )
        );

        $args['name'] = $this->name;

        foreach ($args as $property_name => $property_value) {
            $this->$property_name = $property_value;
        }
    }

    /**
     * Get all available block attributes including possible layout attribute from Columns block.
     *
     * @return array Array of attributes.
     * @since 5.0.0
     *
     */
    public function get_attributes()
    {
        return is_array($this->attributes) ?
            array_merge(
                $this->attributes,
                array(
                    'layout' => array(
                        'type' => 'string',
                    ),
                )
            ) :
            array(
                'layout' => array(
                    'type' => 'string',
                ),
            );
    }
}
