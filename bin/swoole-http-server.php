<?php
/**
 * Date: 2020/5/9
 * Time: 7:00 下午
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Swoole\Http\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Moon\Application;

//$app = new Application(dirname(__DIR__));
//
//$host = env('SW_HTTP_HOST', '0.0.0.0');
//$port = env('SW_HTTP_PORT', 9501);
//
//$server = new Server($host, $port);
//
//$server->on("start", function ($server) use ($host, $port) {
//    echo "Http server listening on http://$host:$port , you can open url http://127.0.0.1:$port in browser.\n";
//});
//
//$server->on('request', function (Request $request, Response $response) use ($app) {
//
//    $res = $app->handleSwooleRequest($request, $response);
//
//    //access log
//    $server = $request->server;
//    $msg = '[' . date('Y-m-d H:i:s') . '] ' . $server['remote_addr'] . ':' . $server['remote_port']
//        . ' ' . $server['request_method'] . ':' . $server['path_info'];
//    $msg .= isset($server['query_string']) ? '?' . $server['query_string'] : '';
//    $msg .= ' ' . $res->getStatusCode();
//    echo $msg . PHP_EOL;
//});
//
//$server->start();

$command = new HttpServerCommand();
$command->execute();


class HttpServerCommand
{
    protected $name = 'http-server';
    protected $pid_file;
    protected $last_config_file;
    protected $log_file;

    public function __construct()
    {
        $root_path = dirname(__DIR__);
        $this->pid_file = $root_path . '/runtime/' . $this->name . '.pid';
        $this->last_config_file = $root_path . '/runtime/' . $this->name . '.json';
        $this->log_file = $root_path . '/runtime/logs/' . $this->name . '.log';
        if (!is_dir($root_path . '/runtime/logs')) {
            mkdir($root_path . '/runtime/logs');
        }
    }

    public function execute()
    {
//        $action = $input->getArgument('action');
        global $argv;
        global $argc;
        //var_dump($argc);exit;
        if ($argc < 2) {
            die("USAGE <action> [option]" . PHP_EOL . "action: start|stop|status|restart|reload");
        }
        //$action = $argv[2];

        //todo
        $options = getopt("h::p::d::", ['host:', 'port:', 'daemon:'], $optind);
        var_dump($optind);
        var_dump($options);
        $pos_args = array_slice($argv, $optind);

        var_dump($pos_args);
        exit;
        $host = $input->getOption('host');
        $port = $input->getOption('port');

        if ($action == 'start') {
            $this->start($host, $port);
        } else if ($action == 'stop') {
            $this->stop();
        } else if ($action == 'restart') {
            $this->stop();
            while (file_exists($this->pid_file)) {
                echo '.';
                usleep(500);
            }
            echo PHP_EOL;
            $config = json_decode(file_get_contents($this->last_config_file), 1);
            $this->start($config['host'], $config['port']);
        } else if ($action == 'status') {
            $this->status();
        } else if ($action == 'reload') {
            //todo
        }
//        var_dump($input->getArguments());
//        var_dump($input->getOptions());

        return 0;
    }

    public function start($host, $port)
    {
        echo "Starting http server\n";
        $server = new Server($host, $port);
        $server->set(['daemonize' => true]);
        $server->set(['worker_num' => 20]);
        $server->set(['log_file' => $this->log_file]);

        $app = new Application(ROOT_PATH);

        $server->on('request', function (Request $request, Response $response) use ($app) {
            $app->handleSwooleRequest($request, $response);
        });

        file_put_contents($this->last_config_file, json_encode(['host' => $host, 'port' => $port]));

        $server->on('start', function (Server $server) use ($host, $port) {
            if ($host == '0.0.0.0') {
                $host = '127.0.0.1';
            }
            echo "Http server listening on http://$host:$port , you can open url http://$host:$port in browser.\n";
            file_put_contents($this->pid_file, $server->master_pid . "\n" . $server->manager_pid);
        });

        $server->on('shutdown', function () {
            echo "Http server is shutdown \n";
            @unlink($this->pid_file);
        });

        $server->start();
    }

    protected function stop()
    {
        $pids = file_exists($this->pid_file) ? file($this->pid_file) : [];
        $master_pid = isset($pids[0]) ? trim($pids[0]) : 0;
        if ($master_pid) {
            $res = exec("kill $master_pid", $output, $return_var);
            //var_dump($res, $output, $return_var);
            if ($return_var === 0) {
                echo "Http server is stop\n";
            } else {
                echo "Http server is failed to stop\n";
            }
        }
    }

    protected function status()
    {
        $config = file_exists($this->last_config_file) ? json_decode(file_get_contents($this->last_config_file), 1) : [];
        $pids = file_exists($this->pid_file) ? file($this->pid_file) : [];
        $master_pid = isset($pids[0]) ? trim($pids[0]) : 0;
        $manager_pid = isset($pids[1]) ? trim($pids[1]) : 0;
//            var_dump($master_pid);

        $command = "ps aux|grep " . $this->name . "|grep -v grep|grep -v status|awk '{print $2}'";
        $res = exec($command, $output, $return_var);
//            var_dump($res, $output, $return_var);
        if ($return_var === 0 && $master_pid > 0 && in_array($master_pid, $output)) {
            sort($output, SORT_ASC);
            echo "PID: " . json_encode($output) . "\n";
            echo "Http server is running at {$config['host']}:{$config['port']}\n";
            echo "Master pid: $master_pid\n";
            echo "Manager pid: $manager_pid\n";
            echo "Worker count: " . (count($output) - 2) . "\n";
        } else {
            echo "Http server is not running\n";
        }
    }
}

