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

$command = new HttpServerCommand();
$command->execute();

class HttpServerCommand
{
    protected $name;
    protected $pid_file;
    protected $last_config_file;
    protected $log_file;
    protected $root_path;

    public function __construct()
    {
        $this->root_path = dirname(__DIR__);
        $this->name = basename(__FILE__);
        $this->pid_file = $this->root_path . '/runtime/tmp/' . $this->name . '.pid';
        $this->last_config_file = $this->root_path . '/runtime/tmp/' . $this->name . '.json';
        $this->log_file = $this->root_path . '/runtime/logs/' . $this->name . '.log';
    }

    public function execute()
    {
        global $argv;
        global $argc;
        if ($argc < 2) {
            die("USAGE [option1,[option2]] <action>" . PHP_EOL . "action: start|stop|status|restart|reload");
        }

        $options = getopt("h::p::d", [], $optind);
        $pos_args = array_slice($argv, $optind);

        $host = $options['h'] ?? '0.0.0.0';
        $port = $options['p'] ?? '8080';
        $daemon = isset($options['d']);
        $action = $pos_args[0] ?? '';

        if ($action == 'start') {
            $this->start($host, $port, $daemon);
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
            $this->start($config['host'], $config['port'], $config['daemon']);
        } else if ($action == 'status') {
            $this->status();
        } else if ($action == 'reload') {
            //todo
        } else {
            die('Need param "action": start|stop|status|restart|reload');
        }

        return 0;
    }

    public function start($host, $port, $daemon)
    {
        echo "Starting http server\n";
        $httpServer = new Server($host, $port);
        if ($daemon) {
            $httpServer->set(['daemonize' => true]);
        }
        $httpServer->set([
            'worker_num' => 20,
            'max_wait_time' => 60, //设置 Worker 进程收到停止服务通知后最大等待时间【默认值：3】
            'reload_async' => true,
            'log_file' => $this->log_file
        ]);

        $app = new Application($this->root_path);

        $httpServer->on('request', function (Request $request, Response $response) use ($app) {

            $res = $app->handleSwooleRequest($request, $response);

            //access log
            $server = $request->server;
            $msg = '[' . date('Y-m-d H:i:s') . '] ' . $server['remote_addr'] . ':' . $server['remote_port']
                . ' ' . $server['request_method'] . ':' . $server['path_info'];
            $msg .= isset($server['query_string']) ? '?' . $server['query_string'] : '';
            $msg .= ' ' . $res->getStatusCode();
            echo $msg . PHP_EOL;
        });

        file_put_contents($this->last_config_file, json_encode(['host' => $host, 'port' => $port, 'daemon' => $daemon]));

        $httpServer->on('start', function (Server $server) use ($host, $port) {
            if ($host == '0.0.0.0') {
                $host = '127.0.0.1';
            }
            echo "Http server listening on http://$host:$port , you can open url http://$host:$port in browser.\n";
            file_put_contents($this->pid_file, $server->master_pid . "\n" . $server->manager_pid);
        });

        $httpServer->on('shutdown', function () {
            echo "Http server is shutdown \n";
            @unlink($this->pid_file);
        });

        $httpServer->start();
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

