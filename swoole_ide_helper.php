<?php
/**
 * Swoole IDE helper
 *
 * ͨ���ø����ļ�ʵ�� Swoole ������ࡢ�������� IDE �����µ��Զ���ȫ��
 *
 * @author Chongyi <xpz3847878@163.com>
 * @see    https://github.com/chongyi/swoole-ide-helper
 */

namespace {

    exit; // ���ļ��Ͻ������룬���� IDE ʶ��ʹ��

    define('SWOOLE_BASE', 1); //ʹ��Baseģʽ��ҵ�������Reactor��ֱ��ִ��
    define('SWOOLE_THREAD', 2); //ʹ���߳�ģʽ��ҵ�������Worker�߳���ִ��
    define('SWOOLE_PROCESS', 3); //ʹ�ý���ģʽ��ҵ�������Worker������ִ��
    define('SWOOLE_PACKET', 0x10);

    define('SWOOLE_SOCK_TCP', 1); //����tcp socket
    define('SWOOLE_SOCK_TCP6', 3); //����tcp ipv6 socket
    define('SWOOLE_SOCK_UDP', 2); //����udp socket
    define('SWOOLE_SOCK_UDP6', 4); //����udp ipv6 socket
    define('SWOOLE_SOCK_UNIX_DGRAM', 5); //����udp socket
    define('SWOOLE_SOCK_UNIX_STREAM', 6); //����udp ipv6 socket
    define('SWOOLE_SSL', 5);
    define('SWOOLE_TCP', 1); //����tcp socket
    define('SWOOLE_TCP6', 2); //����tcp ipv6 socket
    define('SWOOLE_UDP', 3); //����udp socket
    define('SWOOLE_UDP6', 4); //����udp ipv6 socket
    define('SWOOLE_UNIX_DGRAM', 5);
    define('SWOOLE_UNIX_STREAM', 6);
    define('SWOOLE_SOCK_SYNC', 0); //ͬ���ͻ���
    define('SWOOLE_SOCK_ASYNC', 1); //�첽�ͻ���
    define('SWOOLE_SYNC', 0); //ͬ���ͻ���
    define('SWOOLE_ASYNC', 1); //�첽�ͻ���

    define('SWOOLE_FILELOCK', 2); //�����ļ���
    define('SWOOLE_MUTEX', 3); //����������
    define('SWOOLE_RWLOCK', 1); //������д��
    define('SWOOLE_SPINLOCK', 5); //����������
    define('SWOOLE_SEM', 4); //�����ź���
    define('SWOOLE_EVENT_WRITE', 1);
    define('SWOOLE_EVENT_READ', 2);

    /**
     * ����һ��swoole server��Դ����
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
     * ������������swoole_server����ʱ�ĸ��������������������ͨ�� $serv->setting ������ set �������õĲ������顣
     *
     * @param swoole_server $server
     * @param array         $setting
     */
    function swoole_server_set(swoole_server $server, array $setting)
    {
    }

    /**
     * ���ڻ�ȡMySQLi��socket�ļ����������ɽ�mysql��socket���ӵ�swoole�У�ִ���첽MySQL��ѯ��
     *
     * @param mysqli $db
     *
     * @return int
     */
    function swoole_get_mysqli_sock(mysqli $db)
    {
    }

    /**
     * �������ý��̵�����
     *
     * @param string $name
     */
    function swoole_set_process_name($name)
    {
    }

    /**
     * ��ȡswoole��չ�İ汾��
     *
     * @return string
     */
    function swoole_version()
    {
    }

    /**
     * ����׼��Unix Errno������ת���ɴ�����Ϣ
     *
     * @param int $errno
     *
     * @return string
     */
    function swoole_strerror($errno)
    {
    }

    /**
     * ��ȡ���һ��ϵͳ���õĴ����룬��ͬ��C/C++��errno����.
     *
     * @return int
     */
    function swoole_error()
    {
    }

    /**
     * �˺������ڻ�ȡ������������ӿڵ�IP��ַ��Ŀǰֻ����IPv4��ַ�����ؽ������˵�����loop��ַ127.0.0.1��
     * �����������interface����Ϊkey�Ĺ������顣���� array("eth0" => "192.168.1.100")
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
         * ������PID
         *
         * @var int
         */
        public $master_pid;
        /**
         * �������PID
         *
         * @var int
         */
        public $manager_pid;
        /**
         * ��ǰWorker�Ľ���ID����posix_getpid()���һ��
         *
         * @var int
         */
        public $worker_pid;
        /**
         * ��ǰWorker���̵�ID��0 - ($serv->setting[worker_num]-1)
         *
         * @var int
         */
        public $worker_id;


        /**
         * @param string $host      ��������ָ��������ip��ַ����127.0.0.1������������ַ������0.0.0.0����ȫ����ַ��
         *                          IPv4ʹ�� 127.0.0.1��ʾ����������0.0.0.0��ʾ�������е�ַ��
         *                          IPv6ʹ��::1��ʾ����������:: (0:0:0:0:0:0:0:0) ��ʾ�������е�ַ
         * @param int    $port      �����Ķ˿ڣ���9501������С��1024�˿���ҪrootȨ�ޣ�����˶˿ڱ�ռ��server->startʱ��ʧ��
         * @param int    $mode      ���е�ģʽ��swoole�ṩ��3������ģʽ��Ĭ��Ϊ�����ģʽ
         * @param int    $sock_type ָ��socket�����ͣ�֧��TCP/UDP��TCP6/UDP6��UnixSock Stream/Dgram 6�֡�
         *                          ʹ��$sock_type | SWOOLE_SSL��������SSL���ܡ�����SSL���������ssl_key_file��ssl_cert_file��
         *                          1.7.11�������˶�Unix Socket��֧�֣���ϸ��μ� /wiki/page/16.html��
         *                          ���캯���еĲ�����swoole_server::addlistener������ȫ��ͬ�ġ�
         */
        public function __construct($host, $port, $mode = SWOOLE_PROCESS, $sock_type = SWOOLE_SOCK_TCP)
        {
        }

        /**
         * �������� swoole_server����ʱ�ĸ��������������������ͨ�� $serv->setting ������ set �������õĲ������顣
         *
         * @param array $setting ������ɵ�����
         */
        public function set(array $setting)
        {
        }

        /**
         * ע��Server���¼��ص�����
         *
         * @param string   $event    �ص�������, ��Сд�����У��������ݲο��ص������б�.
         * @param callable $callback �ص���PHP�����������Ǻ��������ַ������ྲ̬���������󷽷����飬��������.
         *
         * @return boolean
         */
        public function on($event, callable $callback)
        {
        }

        /**
         * ��ͨ���÷��������Ӽ����Ķ˿ڡ�ҵ������п���ͨ������swoole_server::connection_info����ȡĳ�������������ĸ��˿ڡ�
         *
         * @param string $host      ��������ָ��������ip��ַ����127.0.0.1������������ַ������0.0.0.0����ȫ����ַ��
         *                          IPv4ʹ�� 127.0.0.1��ʾ����������0.0.0.0��ʾ�������е�ַ��
         *                          IPv6ʹ��::1��ʾ����������:: (0:0:0:0:0:0:0:0) ��ʾ�������е�ַ��
         * @param int    $port      �����Ķ˿ڣ���9501������С��1024�˿���ҪrootȨ�ޣ�����˶˿ڱ�ռ��server->startʱ��ʧ�ܡ�
         * @param int    $type      ָ��socket�����ͣ�
         *
         * @return boolean
         */
        public function addListener($host, $port, $type = SWOOLE_SOCK_TCP)
        {
        }

        /**
         * ���һ���û��Զ���Ĺ������̡�
         *
         * @param swoole_process $process swoole_process����ע�ⲻ��Ҫִ��start����swoole_server����ʱ���Զ��������̣�
         *                                ��ִ��ָ�����ӽ��̺�����
         *                                �������ӽ��̿��Ե���$server�����ṩ�ĸ�����������connection_list/connection_info/stats��
         *                                ��worker/task�����п��Ե���$process�ṩ�ķ������ӽ��̽���ͨ�ţ�
         *                                ���û��Զ�������п��Ե���$server->sendMessage��worker/task����ͨ�š�
         *                                �˺���ͨ�����ڴ���һ������Ĺ������̣����ڼ�ء��ϱ������������������
         */
        public function addProcess(swoole_process $process)
        {
        }

        /**
         * ����һ���µ�Server�˿ڣ��˷����� addlistener �ı�����
         *
         * @param string $host      ��������ָ��������ip��ַ����127.0.0.1������������ַ������0.0.0.0����ȫ����ַ��
         *                          IPv4ʹ�� 127.0.0.1��ʾ����������0.0.0.0��ʾ�������е�ַ��
         *                          IPv6ʹ��::1��ʾ����������:: (0:0:0:0:0:0:0:0) ��ʾ�������е�ַ��
         * @param int    $port      �����Ķ˿ڣ���9501������С��1024�˿���ҪrootȨ�ޣ�����˶˿ڱ�ռ��server->startʱ��ʧ�ܡ�
         * @param int    $type      ָ��socket�����ͣ�
         *
         * @return boolean
         */
        public function listen($host, $port, $type = SWOOLE_SOCK_TCP)
        {
        }

        /**
         * ����server����������TCP/UDP�˿�
         *
         * �����ɹ���ᴴ��worker_num+2�����̡�������+Manager����+worker_num��Worker���̡�
         *
         * @return boolean
         */
        public function start()
        {
        }

        /**
         * ��������worker����
         *
         * @param bool|false $only_reload_taskworkrer �Ƿ������task����
         *
         * @return boolean
         */
        public function reload($only_reload_taskworkrer = false)
        {
        }

        /**
         * �رշ�����
         */
        public function shutdown()
        {
        }

        /**
         * ��ָ����ʱ���ִ�к�������Ҫswoole-1.7.7���ϰ汾���÷�����һ��һ���Զ�ʱ����ִ����ɺ�ͻ����١�
         *
         * @param int      $after_time_ms ָ��ʱ�䣬��λΪ����
         * @param callable $callback      ʱ�䵽�ں���ִ�еĺ����������ǿ��Ե��õġ�callback�����������κβ�����
         */
        public function after($after_time_ms, callable $callback)
        {
        }

        /**
         * �رտͻ�������
         *
         * Server���� close ���ӣ�Ҳһ���ᴥ�� onClose �¼�����Ҫ�� close ֮��д�����߼���Ӧ�����õ� onClose �ص��д���
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
         * ��ͻ��˷�������
         *
         * send ��������ԭ���ԣ��������ͬʱ���� send ��ͬһ�����ӷ������ݣ����ᷢ�����ݻ���.
         *
         * @param int    $fd
         * @param string $data ���͵����ݡ�TCPЭ����󲻵ó���2M��UDPЭ�鲻�ó���64K.
         * @param int    $from_id
         *
         * @return boolean
         */
        public function send($fd, $data, $from_id)
        {
        }

        /**
         * �����ļ���TCP�ͻ�������
         *
         * sendfile ��������OS�ṩ�� sendfile ϵͳ���ã��ɲ���ϵͳֱ�Ӷ�ȡ�ļ���д�� socket��sendfile ֻ�� 2 ���ڴ濽����
         * ʹ�ô˺������Խ��ͷ��ʹ����ļ�ʱ����ϵͳ��CPU���ڴ�ռ�á�
         *
         * @param int    $fd
         * @param string $filename Ҫ���͵��ļ�·��������ļ������ڻ᷵��false
         *
         * @return boolean
         */
        public function sendfile($fd, $filename)
        {
        }

        /**
         * ������Ŀͻ��� IP:PORT ���� UDP ���ݰ�
         *
         * @param string     $ip   IPv4�ַ�������192.168.1.102�����IP���Ϸ��᷵�ش���
         * @param int        $port Ϊ 1-65535������˿ںţ�����˿ڴ����ͻ�ʧ��
         * @param string     $data Ҫ���͵��������ݣ��������ı����߶���������
         * @param bool|false $ipv6 �Ƿ�ΪIPv6��ַ����ѡ������Ĭ��Ϊfalse
         *
         * @return boolean
         */
        public function sendto($ip, $port, $data, $ipv6 = false)
        {
        }

        /**
         * ��������ͻ��˷�������
         *
         * ��һЩ����ĳ�����Server��Ҫ������ͻ��˷������ݣ���swoole_server->send���ݷ��ͽӿ��Ǵ��첽�ģ�
         * �������ݷ��ͻᵼ���ڴ淢�Ͷ���������
         *
         * ʹ�� swoole_server->sendwait �Ϳ��Խ�������⣬swoole_server->sendwait �������ȴ����ӿ�д��ֱ�����ݷ�����ϲŻ᷵��.
         *
         * sendwaitĿǰ�������� SWOOLE_BASE ģʽ
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
         * �˺�������������worker���̻���task���̷�����Ϣ���ڷ������̺͹�������пɵ��á��յ���Ϣ�Ľ��̻ᴥ��onPipeMessage�¼���
         *
         * @param string $message       ���͵���Ϣ��������
         * @param int    $dst_worker_id Ŀ����̵�ID����Χ��0 ~ (worker_num + task_worker_num - 1)
         *
         * @return boolean
         */
        public function sendMessage($message, $dst_worker_id)
        {
        }

        /**
         * ���fd��Ӧ�������Ƿ����.��1.7.18���ϰ汾����.
         *
         * @param int $fd ��Ӧ��TCP���Ӵ��ڷ���true�������ڷ���false.
         *
         * @return boolean
         */
        public function exist($fd)
        {
        }

        /**
         * ������ȡ���ӵ���Ϣ
         *
         * ��������fd���ڣ����᷵��һ�����飬���Ӳ����ڻ��ѹرգ�����false����3����������Ϊtrue����ʹ���ӹر�Ҳ�᷵�����ӵ���Ϣ��
         *
         * @param int        $fd
         * @param int        $from_id
         * @param bool|false $ignore_close ��Ϊ true ��ʹ���ӹر�Ҳ�᷵�����ӵ���Ϣ
         *
         * @return array|boolean
         */
        public function connection_info($fd, $from_id, $ignore_close = false)
        {
        }

        /**
         * ����������ǰServer���еĿͻ������ӣ�connection_list�����ǻ��ڹ����ڴ�ģ�������IOWait���������ٶȺܿ졣
         *
         * ����connection_list�᷵������TCP���ӣ����������ǵ�ǰworker���̵�TCP���ӡ�
         *
         * ���óɹ�������һ�������������飬Ԫ����ȡ����$fd������ᰴ��С�����������һ��$fd��Ϊ�µ�start_fd�ٴγ��Ի�ȡ.
         *
         * ����ʧ�ܷ���false
         *
         * @param int $start    ��ʼfd
         * @param int $pagesize ÿҳȡ����������󲻵ó���100
         *
         * @return boolean
         */
        public function connection_list($start = 0, $pagesize = 10)
        {
        }

        /**
         * �����Ӱ�һ���û������ID����������dispatch_mode=5�����Ѵ�IDֵ����hash�̶����䡣
         *
         * ���Ա�֤ĳһ��UID������ȫ������䵽ͬһ��Worker���̡�
         *
         * @param int $fd  ���ӵ��ļ�������
         * @param int $uid ָ��UID
         *
         * @return boolean
         */
        public function bind($fd, $uid)
        {
        }

        /**
         * �õ���ǰServer�ĻTCP������������ʱ�䣬accpet/close���ܴ�������Ϣ��
         *
         * @return array
         */
        public function stats()
        {
        }

        /**
         * Ͷ��һ���첽����task_worker���С��˺������������ء�worker���̿��Լ��������µ�����
         *
         * @param mixed $data          ҪͶ�ݵ��������ݣ�����Ϊ����Դ����֮�������PHP����
         * @param int   $dst_worker_id �����ƶ�Ҫ��Ͷ�ݸ��ĸ�task���̣�����ID���ɣ���Χ��0 - (serv->task_worker_num -1)
         *
         * @return boolean|int
         */
        public function task($data, $dst_worker_id = -1)
        {
        }

        /**
         * taskwait��task����������ͬ������Ͷ��һ���첽������task���̳�ȥִ�С���task��ͬ����taskwait�������ȴ��ģ�
         * ֱ��������ɻ��߳�ʱ���ء�
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
         * �˺���������task������֪ͨworker���̣�Ͷ�ݵ���������ɡ��˺������Դ��ݽ�����ݸ�worker���̡�
         *
         * @param string $message
         */
        public function finish($message)
        {
        }

        /**
         * ���������������ӣ����ҳ��Ѿ�����Լ��ʱ������ӡ����ָ��if_close_connection�����Զ��رճ�ʱ�����ӡ�δָ�����������ӵ�fd���顣
         *
         * @param bool|true $if_close_connection �Ƿ�رճ�ʱ�����ӣ�Ĭ��Ϊtrue
         *
         * @return array|boolean
         */
        public function heartbeat($if_close_connection = true)
        {
        }
    }
}