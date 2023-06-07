<?php

Class TemplateParser {

  static function find_template($template) {
    if (!file_exists($template)) {
      throw new Exception('\''.$template.'\' template not found.');
    }
    return preg_replace('/.+\//', '', $template);
  }

  static function parse($data, $template) {

    $template = self::find_template($template);

    Twig_Autoloader::register();
    $loader = new Twig_Loader_Filesystem(Config::$templates_folder);
    $cache = './app/templates';
    $twig = new Twig_Environment($loader, array(
      'cache' => $cache,
      'auto_reload' => false,
      'autoescape' => false
    ));
    $twig->addExtension(new X3_Twig_Extension());
    $twig->addExtension(new Imagevue_Twig_Extension());

    return $twig->render($template, array('page' => $data));
  }

}

?>