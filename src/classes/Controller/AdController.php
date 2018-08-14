<?php
namespace classes\Controller;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Illuminate\Database\Query\Builder;
use Slim\Views\PhpRenderer;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AdController
{
	//protected $view;
	protected $container;
	//protected $table;
	//protected $db;
	//protected $blog;


   // constructor receives container instance
	public function __construct($container) {		
		$this->container = $container;
		//$this->view = new PhpRenderer("../templates");
	}

	public function __get($property)
	 {
	    if ($this->container->{$property}) {
	        return $this->container->{$property};
	    }
	 }

	public function index(Request $request, Response $response, array $args){
		return  $this->renderer->render($response,'index.phtml'); 	 	
	}
   
	public function blog(Request $request, Response $response, array $args){
	$qry = "select * from blog";
	$rs = $this->db->query($qry);
	
	
	while($row = $rs->fetch_assoc()){
			$blogEntries[] = $row;
		}
	
	$data = array(
		"main_heading" => "Blog",
		"blog_entries" =>$blogEntries
	);
	
	return $this->renderer->render($response, 'blog.html',$data);

	}


	public function getLogin($request,$response,$args){
		$data = array('message' => "");

		return $this->renderer->render($response, 'login.phtml',$data);

	}


	public function postLogin($request,$response,$args){
		$allPost = $request->getParsedBody();
		$user = $allPost['user'];
	
		$pass = ($allPost['pass']);
		if(!$this -> validator($user)){

			$data = array('message' => "User name khong dung dinh dang");
			return $this->renderer->render($response, 'login.phtml', $data);
		}
		$input = $request->getParsedBody();
		$qr = "select * from users where email='".$user."' and pass='".$pass."'";
		$result = $this->db->query($qr);
		$row_cnt = $result->num_rows;

		if ($row_cnt>0){
			// return $this->renderer->redirect($response, 'blog.html');
			// $app->response->redirect($app->urlFor('root'), 303);
			return $response->withRedirect('blog');


		}else{
			echo "đăng nhập không thành công";

		}
	}

	public function validator($username){
		return filter_var($username,FILTER_VALIDATE_EMAIL);
	}
}
