<?php
/*-----------------------------------------------------------------------------------*/
/* Custom Post Type
/*-----------------------------------------------------------------------------------*/
class newPostType
{
    function __construct(array $param)
    {

        add_action('init', array($this, 'create_post_type'));
        $this->name = $param['name'];
        $this->singular_name = $param['singular_name'];
        $this->icon = $param['icon'];
        $this->supports = $param['supports'];
        $this->show_in_rest = isset($param['show_in_rest']) ? $param['show_in_rest'] : false;
        $this->exclude_from_search = isset($param['exclude_from_search']) ? $param['exclude_from_search'] : false;;
        $this->publicly_queryable = isset($param['publicly_queryable']) ? $param['publicly_queryable'] : true;
        $this->show_in_admin_bar = isset($param['show_in_admin_bar']) ? $param['show_in_admin_bar'] : true;
        $this->has_archive = isset($param['has_archive']) ? $param['has_archive'] : true;
        $this->hierarchical = isset($param['hierarchical']) ? $param['hierarchical'] : false;

        if (isset($param['rewrite'])) {
            $this->rewrite = $param['rewrite'];
        } else {
            $this->rewrite = array('slug' => strtolower($this->name));
        }
    }

    function create_post_type()
    {
        register_post_type(
            strtolower($this->name),
            array(
                'labels'              => array(
                    'name'               => _x($this->name, 'post type general name'),
                    'singular_name'      => _x($this->singular_name, 'post type singular name'),
                    'menu_name'          => _x($this->name, 'admin menu'),
                    'name_admin_bar'     => _x($this->singular_name, 'add new on admin bar'),
                    'add_new'            => _x('Add New', strtolower($this->name)),
                    'add_new_item'       => __('Add New ' . $this->singular_name),
                    'new_item'           => __('New ' . $this->singular_name),
                    'edit_item'          => __('Edit ' . $this->singular_name),
                    'view_item'          => __('View ' . $this->singular_name),
                    'all_items'          => __('All ' . $this->name),
                    'search_items'       => __('Search ' . $this->name),
                    'parent_item_colon'  => __('Parent :' . $this->name),
                    'not_found'          => __('No ' . strtolower($this->name) . ' found.'),
                    'not_found_in_trash' => __('No ' . strtolower($this->name) . ' found in Trash.')
                ),
                'show_in_rest'        => $this->show_in_rest,
                'supports'            => $this->supports,
                'public'              => true,
                'has_archive'         => $this->has_archive,
                'hierarchical'        => $this->hierarchical,
                'rewrite'             => $this->rewrite,
                'menu_icon'           => $this->icon,
                'capability_type'     => 'page',
                'exclude_from_search' => $this->exclude_from_search,
                'publicly_queryable'  => $this->publicly_queryable,
                'show_in_admin_bar'   => $this->show_in_admin_bar,
            )
        );
    }
}
/*-----------------------------------------------------------------------------------*/
/* Taxonomy
/*-----------------------------------------------------------------------------------*/
class newTaxonomy
{
    function __construct(array $param)
    {
        add_action('init', array($this, 'create_taxonomy'));
        add_action('restrict_manage_posts', array($this, 'filter_by_taxonomy'), 10, 2);
        add_filter('manage_' . $param['post_type'] . '_posts_columns', array($this, 'change_table_column_titles'));
        add_filter('manage_' . $param['post_type'] . '_posts_custom_column', array($this, 'change_column_rows'), 10, 2);
        add_filter('manage_edit-' . $param['post_type'] . '_sortable_columns', array($this, 'change_sortable_columns'));

        $this->taxonomy = $param['taxonomy'];
        $this->post_type = $param['post_type'];
        $this->args = $param['args'];
    }

    function create_taxonomy()
    {
        register_taxonomy($this->taxonomy, $this->post_type, $this->args);
    }

    function filter_by_taxonomy($post_type, $which)
    {

        // Apply this only on a specific post type
        if ($this->post_type !== $post_type)
            return;

        // A list of taxonomy slugs to filter by
        $taxonomies = array($this->taxonomy);

        foreach ($taxonomies as $taxonomy_slug) {

            // Retrieve taxonomy data
            $taxonomy_obj = get_taxonomy($taxonomy_slug);
            $taxonomy_name = $taxonomy_obj->labels->name;

            // Retrieve taxonomy terms
            $terms = get_terms($taxonomy_slug);

            // Display filter HTML
            echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
            echo '<option value="">' . sprintf(esc_html__('Show All %s', 'text_domain'), $taxonomy_name) . '</option>';
            foreach ($terms as $term) {
                printf(
                    '<option value="%1$s" %2$s>%3$s (%4$s)</option>',
                    $term->slug,
                    ((isset($_GET[$taxonomy_slug]) && ($_GET[$taxonomy_slug] == $term->slug)) ? ' selected="selected"' : ''),
                    $term->name,
                    $term->count
                );
            }
            echo '</select>';
        }
    }
    function change_table_column_titles($columns)
    {
        unset($columns['date']); // temporarily remove, to have custom column before date column
        $columns[$this->taxonomy] = $this->args['label'];
        $columns['date'] = 'Date'; // readd the date column
        return $columns;
    }

    function change_column_rows($column_name, $post_id)
    {
        if ($column_name == $this->taxonomy) {
            echo get_the_term_list($post_id, $this->taxonomy, '', ', ', '') . PHP_EOL;
        }
    }

    function change_sortable_columns($columns)
    {
        $columns[$this->taxonomy] = $this->taxonomy;
        return $columns;
    }
}

new newPostType(
    array(
        'name'                => 'Testimonials',
        'singular_name'       => 'Testimonial',
        'icon'                => 'dashicons-testimonial',
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'show_in_admin_bar'   => false,
        'has_archive'         => false,
        'rewrite'             => array('slug' => 'testimonial'),
        'supports'            => array('title', 'revisions'),
    )
);

new newPostType(
    array(
        'name'          => 'Stockists',
        'singular_name' => 'Stockist',
        'icon'          => 'dashicons-media-text',
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'show_in_admin_bar'   => false,
        'has_archive'         => false,
        'supports'      => array('title', 'revisions', 'thumbnail', 'excerpt'),
        'show_in_rest'  => false,
    )
);


// Add the custom columns to the stockists post type:
add_filter('manage_stockists_posts_columns', 'set_custom_edit_stockists_columns');
function set_custom_edit_stockists_columns($columns)
{
    unset($columns['author']);
    unset($columns['date']);
    $columns['stockist_code'] = __('Stockist Code', 'your_text_domain');

    return $columns;
}

// Add the data to the custom columns for the stockists post type:
add_action('manage_stockists_posts_custom_column', 'custom_stockists_column', 10, 2);
function custom_stockists_column($column, $post_id)
{
    switch ($column) {

        case 'stockist_code':
            echo carbon_get_the_post_meta('stockist_code');
            break;
    }
}


function import_vendors()
{
    add_submenu_page(
        'edit.php?post_type=stockists',
        __('Import Stockists', 'textdomain'),
        __('Import Stockists', 'textdomain'),
        'manage_options',
        'import-stockists',
        'import_vendors_contents'
    );
}

add_action('admin_menu', 'import_vendors');


function import_vendors_contents()
{
?>
    <style>
        .import-form {
            max-width: 500px;
        }

        .import-form .form-control:not(:last-child) {
            margin-bottom: 1.5rem;
        }

        .import-form input {
            width: 100%;
        }

        .import-form .submit {
            font-weight: bold;
            font-size: 16px;
        }

        .import-table {
            overflow: auto;
        }

        .import-table th,
        .import-table td {
            padding: 5px 5px;
        }

        .import-table table {
            width: 100%;
        }

        .import-table>table>tbody>tr {
            padding: 5px;
            flex: 0 0 auto;
            width: 28%;
            border: 1px solid #ececec;
            background-color: #ececec;
        }

        .import-table>table>tbody>tr:nth-child(even) {
            background-color: #fff;
        }
    </style>
    <h1>
        <?php esc_html_e('Import stockist', 'my-plugin-textdomain'); ?>
    </h1>

    <?php if (!$_GET['csv']) { ?>
        <form action="/wp-admin/edit.php" method="GET" class="import-form">
            <div class="form-control">
                <label for="">
                    <h4>Please upload csv in media library and put csv link below.</h4>
                    <input type="hidden" name="post_type" value="stockists">
                    <input type="hidden" name="page" value="import-stockists">
                    <input type="text" name="csv" placeholder="CSV URL" required>
                </label>
            </div>
            <div class="form-control">
                <input type="submit" value="SUBMIT" class="submit button button-primary">
            </div>
        </form>
    <?php } else { ?>
        <h3>CSV URL: <?= $_GET['csv'] ?></h3>
    <?php } ?>
    <?php

    if ($_GET['csv']) {
        $CSVfp = fopen($_GET['csv'], "r");
        if ($CSVfp !== FALSE) {
    ?>
            <div class="import-table">
                <table>
                    <tr>
                        <th>
                            Stockist Code
                        </th>
                        <th>
                            Product ID
                        </th>
                        <th>
                            URL
                        </th>
                    </tr>
                    <?php
                    $row = 0;
                    $meta_name = array();
                    $meta_input = array();

                    while (!feof($CSVfp)) {
                        $data = fgetcsv($CSVfp, 1000, ",");
                        if (!empty($data)) {
                            if ($row == 0) {
                                foreach ($data as $key => $d) {
                                    if ($d != 'categories') {
                                        $meta_name[] = $d;
                                    }
                                }
                            } else {
                                foreach ($data as $key => $d) {
                                    if ($d != 'categories') {
                                        $meta_input[$meta_name[$key]] = $d;
                                    }
                                }
                                $stockist_code = $meta_input['stockist_code'];
                                $product_id = $meta_input['product_id'];
                                $url = $meta_input['url'];

                                $args = array(
                                    'posts_per_page' => 1,
                                    'post_type'  => 'product',
                                    'meta_query' => array(
                                        array(
                                            'key'   => '_stockist_code',
                                            'value' => $stockist_code,
                                        )
                                    )
                                );
                                $postslist = get_posts($args);

                                echo $postslist[0]->ID;

                               // carbon_set_post_meta(10, 'crb_text', 'Hello World!');

                    ?>
                                <tr>

                                    <?php foreach ($meta_input as $key => $d) { ?>
                                        <?php if ($key != '') { ?>
                                            <td>
                                                <?= $d ?>
                                            </td>
                                        <?php } ?>
                                    <?php } ?>

                                </tr>
                            <?php
                            }
                            ?>
                        <?php } ?>
                        <?php $row++; ?>
                    <?php
                    }
                    ?>
                </table>
            </div>
<?php
        }
        fclose($CSVfp);
    }
}
