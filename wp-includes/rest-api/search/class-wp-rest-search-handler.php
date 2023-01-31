<?php
/**
 * REST API: WP_REST_Search_Handler class
 *
 * @package WordPress
 * @subpackage REST_API
 * @since 5.0.0
 */

/**
 * Core base class representing a search handler for an object type in the REST API.
 *
 * @since 5.0.0
 */
abstract class WP_REST_Search_Handler
{

    /**
     * Field containing the IDs in the search result.
     */
    const RESULT_IDS = 'ids';

    /**
     * Field containing the total count in the search result.
     */
    const RESULT_TOTAL = 'total';

    /**
     * Object type managed by this search handler.
     *
     * @since 5.0.0
     * @var string
     */
    protected $type = '';

    /**
     * Object subtypes managed by this search handler.
     *
     * @since 5.0.0
     * @var array
     */
    protected $subtypes = array();

    /**
     * Gets the object type managed by this search handler.
     *
     * @return string Object type identifier.
     * @since 5.0.0
     *
     */
    public function get_type()
    {
        return $this->type;
    }

    /**
     * Gets the object subtypes managed by this search handler.
     *
     * @return array Array of object subtype identifiers.
     * @since 5.0.0
     *
     */
    public function get_subtypes()
    {
        return $this->subtypes;
    }

    /**
     * Searches the object type content for a given search request.
     *
     * @param WP_REST_Request $request Full REST request.
     * @return array Associative array containing an `WP_REST_Search_Handler::RESULT_IDS` containing
     *               an array of found IDs and `WP_REST_Search_Handler::RESULT_TOTAL` containing the
     *               total count for the matching search results.
     * @since 5.0.0
     *
     */
    abstract public function search_items(WP_REST_Request $request);

    /**
     * Prepares the search result for a given ID.
     *
     * @param int $id Item ID.
     * @param array $fields Fields to include for the item.
     * @return array Associative array containing all fields for the item.
     * @since 5.0.0
     *
     */
    abstract public function prepare_item($id, array $fields);

    /**
     * Prepares links for the search result of a given ID.
     *
     * @param int $id Item ID.
     * @return array Links for the given item.
     * @since 5.0.0
     *
     */
    abstract public function prepare_item_links($id);
}
