<?php

function divi_child_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/custom.css');
    wp_enqueue_style( 'alto-contraste', get_stylesheet_directory_uri() . '/alto-contraste.css');
    wp_enqueue_script( 'alto-contraste', get_stylesheet_directory_uri() . '/js/alto-contraste.js');
}

add_action( 'wp_head', 'divi_child_enqueue_styles' );



/*
 * formulário de contato - funções para pegar número de inscricao
 */

// retorna numero de inscricao
function get_num_inscricao() {
  $num_inscricao = get_option('ctav_inscricoes', 500);
  return $num_inscricao;
}

// define nova inscricao
function set_nova_inscricao() {
  $num_inscricao = get_option('ctav_inscricoes') + 1;
  update_option('ctav_inscricoes', $num_inscricao);
}

// funcao para executar antes do envio de emails
function numero_nova_inscricao($posted_data) {
    $nova_inscricao = get_num_inscricao();
    $posted_data['numero_inscricao'] = $nova_inscricao;
    return $posted_data;
}

// incrementa inscricao no hook de email pronto para envio (pos-validacao)
function incrementa_inscricao($wpcf) {
    set_nova_inscricao();
    return $wpcf;
}

add_shortcode( 'num_inscricao', 'num_inscricao');
add_action('wpcf7_before_send_mail', 'set_nova_inscricao');
add_action('wpcf7_posted_data', 'numero_nova_inscricao');

?>
