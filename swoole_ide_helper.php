<?php
/**
 * Swoole IDE helper
 *
 * 通过该辅助文件实现 Swoole 的相关类、函数等在 IDE 环境下的自动补全。
 *
 * @author Chongyi <xpz3847878@163.com>
 * @see    https://github.com/chongyi/swoole-ide-helper
 */

namespace {

    exit; // 该文件严禁被载入，仅供 IDE 识别使用

    define('SWOOLE_BASE', 1); //使用Base模式，业务代码在Reactor中直接执行
    define('SWOOLE_THREAD', 2); //使用线程模式，业务代码在Worker线程中执行
    define('SWOOLE_PROCESS', 3); //使用进程模式，业务代码在Worker进程中执行
    define('SWOOLE_PACKET', 0x10);

    define('SWOOLE_SOCK_TCP', 1); //创建tcp socket
    define('SWOOLE_SOCK_TCP6', 3); //创建tcp ipv6 socket
    define('SWOOLE_SOCK_UDP', 2); //创建udp socket
    define('SWOOLE_SOCK_UDP6', 4); //创建udp ipv6 socket
    define('SWOOLE_SOCK_UNIX_DGRAM', 5); //创建udp socket
    define('SWOOLE_SOCK_UNIX_STREAM', 6); //创建udp ipv6 socket
    define('SWOOLE_SSL', 5);
    define('SWOOLE_TCP', 1); //创建tcp socket
    define('SWOOLE_TCP6', 2); //创建tcp ipv6 socket
    define('SWOOLE_UDP', 3); //创建udp socket
    define('SWOOLE_UDP6', 4); //创建udp ipv6 socket
    define('SWOOLE_UNIX_DGRAM', 5);
    define('SWOOLE_UNIX_STREAM', 6);
    define('SWOOLE_SOCK_SYNC', 0); //同步客户端
    define('SWOOLE_SOCK_ASYNC', 1); //异步客户端
    define('SWOOLE_SYNC', 0); //同步客户端
    define('SWOOLE_ASYNC', 1); //异步客户端

    define('SWOOLE_FILELOCK', 2); //创建文件锁
    define('SWOOLE_MUTEX', 3); //创建互斥锁
    define('SWOOLE_RWLOCK', 1); //创建读写锁
    define('SWOOLE_SPINLOCK', 5); //创建自旋锁
    define('SWOOLE_SEM', 4); //创建信号量
    define('SWOOLE_EVENT_WRITE', 1);
    define('SWOOLE_EVENT_READ', 2);

    /**
     * 创建一个swoole server资源对象
     *
     * @param     $host
     * @param     $port
     * @param int $mode
     * @param int $sock_type
     *
     * @return swoole_server
     */
    function swoole_server_create($host, $port, $mode = SWOOLE_PROCESS, $sock_type = SWOOLE_SOCK_TCP)
    {
    }

    /**
     * 函数用于设置swoole_server运行时的各项参数。服务器启动后通过 $serv->setting 来访问 set 函数设置的参数数组。
     *
     * @param swoole_server $server
     * @param array         $setting
     */
    function swoole_server_set(swoole_server $server, array $setting)
    {
    }

    /**
     * 用于获取MySQLi的socket文件描述符。可将mysql的socket增加到swoole中，执行异步MySQL查询。
     *
     * @param mysqli $db
     *
     * @return int
     */
    function swoole_get_mysqli_sock(mysqli $db)
    {
    }

    /**
     * 用于设置进程的名称
     *
     * @param string $name
     */
    function swoole_set_process_name($name)
    {
    }

    /**
     * 获取swoole扩展的版本号
     *
     * @return string
     */
    function swoole_version()
    {
    }

    /**
     * 将标准的Unix Errno错误码转换成错误信息
     *
     * @param int $errno
     *
     * @return string
     */
    function swoole_strerror($errno)
    {
    }

    /**
     * 获取最近一次系统调用的错误码，等同于C/C++的errno变量.
     *
     * @return int
     */
    function swoole_error()
    {
    }

    /**
     * 此函数用于获取本机所有网络接口的IP地址，目前只返回IPv4地址，返回结果会过滤掉本地loop地址127.0.0.1。
     * 结果数组是以interface名称为key的关联数组。比如 array("eth0" => "192.168.1.100")
     *
     * @return array
     */
    function swoole_get_local_ip()
    {
    }

    /**
     * Class swoole_server
     */
    class swoole_server
    {
        /**
         * 主进程PID
         *
         * @var int
         */
        public $master_pid;

        /**
         * 管理进程PID
         *
         * @var int
         */
        public $manager_pid;

        /**
         * 当前Worker的进程ID，与posix_getpid()结果一致
         *
         * @var int
         */
        public $worker_pid;

        /**
         * 当前Worker进程的ID，0 - ($serv->setting[worker_num]-1)
         *
         * @var int
         */
        public $worker_id;

        /**
         * 是否 Task 工作进程
         *
         *  true  表示当前的进程是Task工作进程
         *  false 表示当前的进程是Worker进程
         *
         * @var bool
         */
        public $taskworker;

        /**
         * TCP连接迭代器，可以使用foreach遍历服务器当前所有的连接，此属性的功能与swoole_server->connnection_list是一致的，但是更加友好。遍历的元素为单个连接的fd
         *
         * 连接迭代器依赖pcre库，未安装pcre库无法使用此功能
         *
         *      foreach($server->connections as $fd)
         *      {
         *          $server->send($fd, "hello");
         *      }
         *
         *      echo "当前服务器共有 ".count($server->connections). " 个连接\n";
         *
         * @var array
         */
        public $connections;


        /**
         * @param string $host      参数用来指定监听的ip地址，如127.0.0.1，或者外网地址，或者0.0.0.0监听全部地址。
         *                          IPv4使用 127.0.0.1表示监听本机，0.0.0.0表示监听所有地址；
         *                          IPv6使用::1表示监听本机，:: (0:0:0:0:0:0:0:0) 表示监听所有地址
         * @param int    $port      监听的端口，如9501，监听小于1024端口需要root权限，如果此端口被占用server->start时会失败
         * @param int    $mode      运行的模式，swoole提供了3种运行模式，默认为多进程模式
         * @param int    $sock_type 指定socket的类型，支持TCP/UDP、TCP6/UDP6、UnixSock Stream/Dgram 6种。
         *                          使用$sock_type | SWOOLE_SSL可以启用SSL加密。启用SSL后必须配置ssl_key_file和ssl_cert_file。
         *                          1.7.11后增加了对Unix Socket的支持，详细请参见 /wiki/page/16.html。
         *                          构造函数中的参数与swoole_server::addlistener中是完全相同的。
         */
        public function __construct($host, $port, $mode = SWOOLE_PROCESS, $sock_type = SWOOLE_SOCK_TCP)
        {
        }

        /**
         * 用于设置 swoole_server运行时的各项参数。服务器启动后通过 $serv->setting 来访问 set 方法设置的参数数组。
         *
         * @param array $setting 设置项构成的数组
         */
        public function set(array $setting)
        {
        }

        /**
         * 注册Server的事件回调函数
         *
         * @param string   $event    回调的名称, 大小写不敏感，具体内容参考回调函数列表.
         * @param callable $callback 回调的PHP函数，可以是函数名的字符串，类静态方法，对象方法数组，匿名函数.
         *
         * @return boolean
         */
        public function on($event, callable $callback)
        {
        }

        /**
         * 可通过该方法来增加监听的端口。业务代码中可以通过调用swoole_server::connection_info来获取某个连接来自于哪个端口。
         *
         * @param string $host      参数用来指定监听的ip地址，如127.0.0.1，或者外网地址，或者0.0.0.0监听全部地址。
         *                          IPv4使用 127.0.0.1表示监听本机，0.0.0.0表示监听所有地址；
         *                          IPv6使用::1表示监听本机，:: (0:0:0:0:0:0:0:0) 表示监听所有地址。
         * @param int    $port      监听的端口，如9501，监听小于1024端口需要root权限，如果此端口被占用server->start时会失败。
         * @param int    $type      指定socket的类型，
         *
         * @return boolean
         */
        public function addListener($host, $port, $type = SWOOLE_SOCK_TCP)
        {
        }

        /**
         * 添加一个用户自定义的工作进程。
         *
         * @param swoole_process $process swoole_process对象，注意不需要执行start。在swoole_server启动时会自动创建进程，
         *                                并执行指定的子进程函数；
         *                                创建的子进程可以调用$server对象提供的各个方法，如connection_list/connection_info/stats；
         *                                在worker/task进程中可以调用$process提供的方法与子进程进行通信；
         *                                在用户自定义进程中可以调用$server->sendMessage与worker/task进程通信。
         *                                此函数通常用于创建一个特殊的工作进程，用于监控、上报或者其他特殊的任务。
         */
        public function addProcess(swoole_process $process)
        {
        }

        /**
         * 监听一个新的Server端口，此方法是 addlistener 的别名。
         *
         * @param string $host      参数用来指定监听的ip地址，如127.0.0.1，或者外网地址，或者0.0.0.0监听全部地址。
         *                          IPv4使用 127.0.0.1表示监听本机，0.0.0.0表示监听所有地址；
         *                          IPv6使用::1表示监听本机，:: (0:0:0:0:0:0:0:0) 表示监听所有地址。
         * @param int    $port      监听的端口，如9501，监听小于1024端口需要root权限，如果此端口被占用server->start时会失败。
         * @param int    $type      指定socket的类型，
         *
         * @return boolean
         */
        public function listen($host, $port, $type = SWOOLE_SOCK_TCP)
        {
        }

        /**
         * 启动server，监听所有TCP/UDP端口
         *
         * 启动成功后会创建worker_num+2个进程。主进程+Manager进程+worker_num个Worker进程。
         *
         * @return boolean
         */
        public function start()
        {
        }

        /**
         * 重启所有worker进程
         *
         * @param bool|false $only_reload_taskworkrer 是否仅重启task进程
         *
         * @return boolean
         */
        public function reload($only_reload_taskworkrer = false)
        {
        }

        /**
         * 关闭服务器
         */
        public function shutdown()
        {
        }

        /**
         * 在指定的时间后执行函数，需要swoole-1.7.7以上版本。该方法是一个一次性定时器，执行完成后就会销毁。
         *
         * @param int      $after_time_ms 指定时间，单位为毫秒
         * @param callable $callback      时间到期后所执行的函数，必须是可以调用的。callback函数不接受任何参数。
         */
        public function after($after_time_ms, callable $callback)
        {
        }

        /**
         * 关闭客户端连接
         *
         * Server主动 close 连接，也一样会触发 onClose 事件。不要在 close 之后写清理逻辑。应当放置到 onClose 回调中处理。
         *
         * @param int $fd
         * @param int $from_id
         *
         * @return boolean
         */
        public function close($fd, $from_id)
        {
        }

        /**
         * 向客户端发送数据
         *
         * send 操作具有原子性，多个进程同时调用 send 向同一个连接发送数据，不会发生数据混杂.
         *
         * @param int    $fd
         * @param string $data 发送的数据。TCP协议最大不得超过2M，UDP协议不得超过64K.
         * @param int    $from_id
         *
         * @return boolean
         */
        public function send($fd, $data, $from_id)
        {
        }

        /**
         * 发送文件到TCP客户端连接
         *
         * sendfile 方法调用OS提供的 sendfile 系统调用，由操作系统直接读取文件并写入 socket。sendfile 只有 2 次内存拷贝，
         * 使用此函数可以降低发送大量文件时操作系统的CPU和内存占用。
         *
         * @param int    $fd
         * @param string $filename 要发送的文件路径，如果文件不存在会返回false
         *
         * @return boolean
         */
        public function sendfile($fd, $filename)
        {
        }

        /**
         * 向任意的客户端 IP:PORT 发送 UDP 数据包
         *
         * @param string     $ip   IPv4字符串，如192.168.1.102。如果IP不合法会返回错误
         * @param int        $port 为 1-65535的网络端口号，如果端口错误发送会失败
         * @param string     $data 要发送的数据内容，可以是文本或者二进制内容
         * @param bool|false $ipv6 是否为IPv6地址，可选参数，默认为false
         *
         * @return boolean
         */
        public function sendto($ip, $port, $data, $ipv6 = false)
        {
        }

        /**
         * 阻塞地向客户端发送数据
         *
         * 有一些特殊的场景，Server需要连续向客户端发送数据，而swoole_server->send数据发送接口是纯异步的，
         * 大量数据发送会导致内存发送队列塞满。
         *
         * 使用 swoole_server->sendwait 就可以解决此问题，swoole_server->sendwait 会阻塞等待连接可写。直到数据发送完毕才会返回.
         *
         * sendwait目前仅可用于 SWOOLE_BASE 模式
         *
         * @param int    $fd
         * @param string $data
         *
         * @return boolean
         */
        public function sendwait($fd, $data)
        {
        }

        /**
         * 此函数可以向任意worker进程或者task进程发送消息。在非主进程和管理进程中可调用。收到消息的进程会触发onPipeMessage事件。
         *
         * @param string $message       发送的消息数据内容
         * @param int    $dst_worker_id 目标进程的ID，范围是0 ~ (worker_num + task_worker_num - 1)
         *
         * @return boolean
         */
        public function sendMessage($message, $dst_worker_id)
        {
        }

        /**
         * 检测fd对应的连接是否存在.在1.7.18以上版本可用.
         *
         * @param int $fd 对应的TCP连接存在返回true，不存在返回false.
         *
         * @return boolean
         */
        public function exist($fd)
        {
        }

        /**
         * 用来获取连接的信息
         *
         * 如果传入的fd存在，将会返回一个数组，连接不存在或已关闭，返回false。第3个参数设置为true，即使连接关闭也会返回连接的信息。
         *
         * @param int        $fd
         * @param int        $from_id
         * @param bool|false $ignore_close 若为 true 即使连接关闭也会返回连接的信息
         *
         * @return array|boolean
         */
        public function connection_info($fd, $from_id, $ignore_close = false)
        {
        }

        /**
         * 用来遍历当前Server所有的客户端连接，connection_list方法是基于共享内存的，不存在IOWait，遍历的速度很快。
         *
         * 另外connection_list会返回所有TCP连接，而不仅仅是当前worker进程的TCP连接。
         *
         * 调用成功将返回一个数字索引数组，元素是取到的$fd。数组会按从小到大排序。最后一个$fd作为新的start_fd再次尝试获取.
         *
         * 调用失败返回false
         *
         * @param int $start    起始fd
         * @param int $pagesize 每页取多少条，最大不得超过100
         *
         * @return boolean
         */
        public function connection_list($start = 0, $pagesize = 10)
        {
        }

        /**
         * 将连接绑定一个用户定义的ID，可以设置dispatch_mode=5设置已此ID值进行hash固定分配。
         *
         * 可以保证某一个UID的连接全部会分配到同一个Worker进程。
         *
         * @param int $fd  连接的文件描述符
         * @param int $uid 指定UID
         *
         * @return boolean
         */
        public function bind($fd, $uid)
        {
        }

        /**
         * 得到当前Server的活动TCP连接数，启动时间，accpet/close的总次数等信息。
         *
         * @return array
         */
        public function stats()
        {
        }

        /**
         * 投递一个异步任务到task_worker池中。此函数会立即返回。worker进程可以继续处理新的请求。
         *
         * @param mixed $data          要投递的任务数据，可以为除资源类型之外的任意PHP变量
         * @param int   $dst_worker_id 可以制定要给投递给哪个task进程，传入ID即可，范围是0 - (serv->task_worker_num -1)
         *
         * @return boolean|int
         */
        public function task($data, $dst_worker_id = -1)
        {
        }

        /**
         * taskwait与task方法作用相同，用于投递一个异步的任务到task进程池去执行。与task不同的是taskwait是阻塞等待的，
         * 直到任务完成或者超时返回。
         *
         * @param mixed $task_data
         * @param float $timeout
         * @param int   $dst_worker_id
         *
         * @return string|boolean
         */
        public function taskwait($task_data, $timeout = 0.5, $dst_worker_id = -1)
        {
        }

        /**
         * 此函数用于在task进程中通知worker进程，投递的任务已完成。此函数可以传递结果数据给worker进程。
         *
         * @param string $message
         */
        public function finish($message)
        {
        }

        /**
         * 检测服务器所有连接，并找出已经超过约定时间的连接。如果指定if_close_connection，则自动关闭超时的连接。未指定仅返回连接的fd数组。
         *
         * @param bool|true $if_close_connection 是否关闭超时的连接，默认为true
         *
         * @return array|boolean
         */
        public function heartbeat($if_close_connection = true)
        {
        }
    }

    class swoole_http_server extends swoole_server
    {

    }
}