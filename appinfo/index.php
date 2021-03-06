<?php
OCP\User::checkLoggedIn();
OCP\App::checkAppEnabled('dudle');
OCP\App::setActiveNavigationEntry('dudle');

// use a custom template subclass to avoid the need for an extra templates subdirectory
class SimpleTemplate extends OCP\Template {
	private $content;
	public function __construct($app, $content) {
		$this->content = $content;
		parent::__construct($app, $app, 'user');
	}
	protected function findTemplate($theme, $app, $name) {
		if ($name !== $app) return parent::findTemplate($theme, $app, $name);
		return array('', $app);
	}
	protected function load($file, $params = null) {
		if ($file !== $this->app) return parent::load($file, $params);
		return $this->content;
	}
}

ob_start();
?>
	<div style="height:100%;overflow:auto;-webkit-overflow-scrolling:touch;"><iframe src="<?php echo OCP\Util::linkToAbsolute('dudle', '') ?>" style="width:100%;height:100%;margin-bottom:-5px;"></iframe></div>
<?php
$iframe = ob_get_contents();
@ob_end_clean();

$template = new SimpleTemplate('dudle', $iframe);
$template->printPage();
