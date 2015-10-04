<?php
namespace Codeception\Extension;

use Codeception\Event\PrintResultEvent;
use Codeception\Events;
use Codeception\Extension;
use Codeception\Lib\TestDescriptor;
use Codeception\TestCase;

/**
 * Saves failed tests into tests/log/failed in order to rerun failed tests.
 *
 * To rerun failed tests just run the `failed` group:
 *
 * ```
 * php codecept run -g failed
 * ```
 *
 * Starting from Codeception 2.1 **this extension is enabled by default**.
 *
 * ``` yaml
 * extensions:
 *     enabled: [Codeception\Extension\RunFailed]
 * ```
 *
 * On each execution failed tests are logged and saved into `tests/_output/failed` file.
 */
class RunFailed extends Extension
{
    static $events = [
        Events::RESULT_PRINT_AFTER => 'saveFailed'
    ];

    protected $config = ['file' => 'failed'];

    public function _initialize()
    {
        $logPath = str_replace($this->getRootDir(), '', $this->getLogDir()); // get local path to logs
        $this->_reconfigure(['groups' => ['failed' => $logPath . $this->config['file']]]);
    }

    public function saveFailed(PrintResultEvent $e)
    {
        $file = $this->getLogDir() . $this->config['file'];
        $result = $e->getResult();
        if ($result->wasSuccessful()) {
            if (is_file($file)) {
                unlink($file);
            }
            return;
        }
        $output = [];
        foreach ($result->failures() as $fail) {
            $output[] = $this->localizePath(TestDescriptor::getTestFullName($fail->failedTest()));
        }
        foreach ($result->errors() as $fail) {
            $output[] = $this->localizePath(TestDescriptor::getTestFullName($fail->failedTest()));
        }

        file_put_contents($file, implode("\n", $output));
    }

    protected function localizePath($path)
    {
        $root = realpath($this->getRootDir()) . DIRECTORY_SEPARATOR;
        if (substr($path, 0, strlen($root)) == $root) {
            return substr($path, strlen($root));
        }
        return $path;
    }

} 