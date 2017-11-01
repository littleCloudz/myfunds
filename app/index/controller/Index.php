<?php
namespace app\index\controller;
use app\common\controller\Index as commonIndex;
use think\Config;
use think\Env;
use think\Db;
use PHPExcel_IOFactory;
use PHPExcel;
class Index
{
    public function __construct()
    {
        config('before', 'beforeAction');
    }
    public function index()
    {
        // return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
        // return "this is index index index";
        // $common = new commonIndex();
    	// return $common->index();
        dump(config());
        // $conf1 = [
        //     'username'  => 'wuyunlong'
        // ];
        // $conf2 = [
        //     'username'  => 'along'
        // ];
        // dump(array_merge($conf1, $conf2));

        // $res = \think\Config::get();
        // $res = Config::get();
        // dump($res);

        // Config::set('username', 'along', 'index');
        // dump(Config::get('username', 'index'));

        // dump(config('?username'));

        // dump($_ENV);
        // $res = Env::get('email');
        // $res = Env::get('email2', 'default_value');
        // $res = Env::get('database_hostname', 'default_value');
        // $res = Env::get('database.hostname', 'default_value');
        // dump($res);
    }
    public function common(){
    	$common = new commonIndex();
    	return $common->index();
    }

     public function info($id)
    {
        //http://127.0.0.1:8099/myfunds/public/index/index/info/id/5
        //http://127.0.0.1:8099/myfunds/public/news/5.html
        echo url('index/index/index', ['id' => 10]) ."<br>";
        echo url('index/index/info', ['id' => 10]) ."<br>";
        return "{$id}";
    }

    public function demo()
    {
        dump(config());
        //1
        // $res = Db::connect();//惰性加载，使用时才连接
        //2
        // $res = Db::connect([
        //     // 数据库类型
        //     'type'            => 'mysql',
        //     // 服务器地址
        //     'hostname'        => '127.0.0.1',
        //     // 数据库名
        //     'database'        => '',
        //     // 用户名
        //     'username'        => 'root',
        //     // 密码
        //     'password'        => '',
        //     // 端口
        //     'hostport'        => '',
        //     // 连接dsn
        //     'dsn'             => '',
        //     // 数据库连接参数
        //     'params'          => [],
        //     // 数据库编码默认采用utf8
        //     'charset'         => 'utf8',
        //     // 数据库表前缀
        //     'prefix'          => '',
        // ]);
        //3
        // $res = Db::connect("mysql://root:123456@127.0.0.1:3306/course#utf8");//惰性加载，使用时才连接
        //4
        // $res = Db::connect('db_config_imooc');//惰性加载，使用时才连接

        //5
        // $res = Db::connect(Config::get('db_config_imooc'));//Config::get返回数组


        // dump(config('database'));

        // $res = Db::query("select * from imooc_user where id=?", [1]);
        // $res = Db::execute("insert into imooc_user set username=?,password=?,email=?",[
        //     'imooc',
        //     md5('imooc'),
        //     'imooc@qq.com'
        //     ]);
        // $res = Db::table('imooc_user')->where([
        //         'id' => '1'
        //     ])->select();
        //select 所有记录，二维数组 结果不存在 空数组
        // $res = Db::table('imooc_user')->select();

        //column 一维数组,数组中的value值就是我们要获取的列的值 结果不存在 空数组
        //第二个参数作为key
        // $res = Db::table('imooc_user')->column('email', 'username');


        //find 一维数组 id正序排列 一条记录 结果不存在 null
        // $res = Db::table('imooc_user')->where([
        //         'id' => '10'
        //     ])->find();

        //value 一条记录 结果不存在 null
        // $res = Db::table('imooc_user')->where([
        //         'id' => '10'
        //     ])->value('username');

        // $res = Db::name('user')->select();
        // $res = db('user',[],false)->select();//db助手函数，不要实例化 Db类是单例模式 

        $this->printExcel();
        $db = Db::name('expense');
        // $db->insert([
        //     'email' => 'imooc_03@qq.com',
        //     'password' => md5('imooc_03'),
        //     'username' => 'imooc_03'
        // ]);
        $res = $db -> select();
        dump($res);
    }

    public function readExcel(){
        $path = dirname(__FILE__); //找到当前脚本所在路径
        // dump($path);
        error_reporting(E_ALL);  
        // date_default_timezone_set('Asia/ShangHai');  
        // include_once('Classes/PHPExcel/IOFactory.php');//包含类文件  
          
        $filename = $path.'\myMoney.xls';
        if (!file_exists($filename)) {  
        exit("not found.\n");  
        }  
          
        $ext = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
        if($ext == 'xlsx'){
            $reader=PHPExcel_IOFactory::createReader('Excel2007');
            $PHPExcel = $reader->load($filename,'utf-8');
        }elseif($ext == 'xls'){
            $reader=PHPExcel_IOFactory::createReader('Excel5');
            $PHPExcel = $reader->load($filename,'utf-8');
        }

        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表  
        $highestRow = $sheet->getHighestRow(); // 取得总行数  
        $highestColumm = $sheet->getHighestColumn(); // 取得总列数  

        $excelData = array();
        for ($row =1; $row <= $highestRow; $row++){//行数是以第1行开始  

            for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始  
                    $excelData[$row][$column] = $sheet->getCell($column.$row)->getValue();
                
            }
        }  
        $res['excelData'] = $excelData;
        $res['highestRow'] = $highestRow;
        $res['highestColumm'] = $highestColumm;
        return $res;
    }

    public function  printExcel()
    {
        $res = $this->readExcel();
        // dump($exceldata);

        /** 循环读取每个单元格的数据 */  
        echo "<table border=1>";  
        for ($row =1; $row <= $res['highestRow']; $row++){//行数是以第1行开始  
            echo "<tr>";  
            echo "<td>".$row."</td>";  
            for ($column = 'A'; $column <= $res['highestColumm']; $column++) {//列数是以A列开始  
                
                    echo "<td>".$res['excelData'][$row][$column]."</td>";  
            }
            echo "</tr>";  
        }  
        echo "</table>"; 
    }

    public function  saveToDb()
    {
        $res = $this->readExcel();
        // dump($exceldata);

        // $this->printExcel();
        $db = Db::name('expense');
        $rowData = array();
        $key = [
            'A' => 'transactionType',
            'B' => 'date',
            'C' => 'category',
            'D' => 'subCategory',
            'E' => 'accountOut',
            'F' => 'accountIn',
            'G' => 'project',
            'H' => 'member',
            'I' => 'merchant',
            'J' => 'sum',
            'K' => 'notes',
        ];
        /** 循环读取每个单元格的数据 */  
        for ($row =1; $row <= $res['highestRow']; $row++){//行数是以第1行开始  
            $rowData[$row]['id'] = $row;
            for ($column = 'A'; $column <= $res['highestColumm']; $column++) {//列数是以A列开始  
                    $columnName = $key[$column];
                    $rowData[$row][$columnName] = $res['excelData'][$row][$column];
            }
        }  

        // $res = $db->insertAll($rowData);
     

        $data = $db -> select();
        dump($data);
    }


}
