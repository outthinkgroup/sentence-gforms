<?php
GFForms::include_addon_framework();
 
class GFSentenceAddon extends GFAddOn {

    protected $_version = GF_SENTENCE_FORM_ADDON_VERSION;
    protected $_min_gravityforms_version = '1.9';
    protected $_slug = 'gf_sentence_addon';
    protected $_path = 'sentence-gforms/sentence-addon.php';
    protected $_full_path = __FILE__;
    protected $_title = 'Gravity Forms Sentence Add-On';
    protected $_short_title = 'Sentence Add-On';

    private static $_instance = null;
 
    public static function get_instance() {
        if ( self::$_instance == null ) {
            self::$_instance = new GFSentenceAddon();
        }
        return self::$_instance;
    }
    
    public function init(){
        parent::init();

        add_filter( 'gform_field_content',[$this, 'make_it_template'], 10, 5 );
        add_action('gform_enqueue_scripts', [$this, 'frontend_assets']);
    }
    
    /**
    @param string $field_content The field content to be filtered.
    @param Field Object $field The field that this input tag applies to.
    @param string $value  The default/initial value that the field should be pre-populated with.
    @param integer $entry_id When executed from the entry detail screen, $lead_id will be populated with the Entry ID. Otherwise, it will be 0.
    @param integer $form_id The current Form ID.
    **/
    function make_it_template($field_content, $field, $value, $entry_id, $form_id){
        if(is_admin())return $field_content;

        $form = GFAPI::get_form($form_id);
        if(!$this->is_enabled($form)) return $field_content;
        if($field->type != "html"){
            return "<div hidden data-field-name='".$field->label."' data-field-type='".$field->type."'>".$field_content."</div>";
        }
        return "<template id='form_template'>".$field_content."</template>";
    }
    public function frontend_assets($form){
        if($this->is_enabled($form)){
            wp_enqueue_style('sentence-form-css', GF_SENTENCE_FORM_ADDON_URL . '/css/sentence-form.css');
            wp_enqueue_script('sentence-form-js', GF_SENTENCE_FORM_ADDON_URL . '/js/sentence-form.js');
        }
    }

    public function is_enabled($form){
        return isset($form['gf_sentence_addon']) && isset($form['gf_sentence_addon']['enabled']) && $form['gf_sentence_addon']['enabled'];
    }

    public function form_settings_fields( $form ) {
        return [
            [
                'title'  => "Sentence Addon Setting",
                'fields' => [
                    [
                        'label'   => 'Enable Sentence Structure for this form',
                        'type'    => 'checkbox',
                        'name'    => 'enabled',
                        'tooltip' => "Checking this will turn the form in to a sentence using the html form field",
                        'choices' => [
                            [
                                'label' => 'Enable',
                                'name'  => 'enabled',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }


}
