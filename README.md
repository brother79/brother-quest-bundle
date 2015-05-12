# Information
# Installation
## Get the bundle

Let Composer download and install the bundle by running
```sh
php composer.phar require brother/quest-bundle:dev-master
```
in a shell.
## Enable the bundle
```php
// in app/AppKernel.php
public function registerBundles() {
	$bundles = array(
		// ...
            new Brother\QuestBundle\BrotherQuestBundle(),
	);
	// ...
}
```
## enable error notifier

# Usage



