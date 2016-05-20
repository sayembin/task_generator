<?php
namespace api;

require_once(__DIR__.'/../autoloader.php');

use Config\config as con;

/**
 * this is a custom rest api
 * Class api
 * this class response all the calls from call php
 * @author Md.Sayem bin hasan <sayemdoc@gmail.com>
 * @version 1.01
 * @package api
 */
class api
{
	/**
	 * get the db settings
	 *
	 * @var Array
	 */
	private $settings;

	/**
	 * This variable contains all database connection
	 * settings
	 *
	 * @var PDOobject $conn database connection
	 */
	private $conn;

	/**
	 * construcator get the mysql connection and database settings
	 * @return void
	 */
	function __construct()
	{
		$this->settings = con::getConfig();
		$this->mysqlConn();
	}

	/**
	 * this method take login credentials as username and password and the set
	 * the session if the credentials is valid
	 *
	 * @param array $loginData login credentials
	 * @return JSONObject
	 */
	public function login($loginData = array())
	{
		if (!empty($loginData['username']) && !empty($loginData['password'])) {
			$sql = "SELECT id FROM xtwo_user WHERE username='" . mysql_real_escape_string($loginData['username'])
				. "' AND password='" . md5(mysql_real_escape_string($loginData['password'])) . "'";
			$q = $this->conn->query($sql);
			if ($q->rowCount() > 0) {
				$check = $q->fetchAll(\PDO::FETCH_ASSOC);
				$row_id = $check[0]['id'];
				session_start();
				$_SESSION["authenticated"] = $row_id;
				echo json_encode('success');

			} else {
				echo json_encode('failure');
			}

		} else {
			echo json_encode('failure');
		}

	}

	/**
	 * register the user
	 *
	 * @param array $regData
	 * @return JSONObject
	 */
	public function registration($regData = array())
	{
		if (!empty($regData['username']) && !empty($regData['password'])) {
			$username = $regData['username'];
			$password = $regData['password'];
		}
		$sql = "INSERT INTO xtwo_user (username,password) VALUES (:username,:password)";
		$q = $this->conn->prepare($sql);
		$q->execute(
			array(
				':username' => $username,
				':password' => md5($password)
			)
		);

		echo json_encode('sucess');
	}

	/**
	 * this method take task name and create a new task
	 * @param string $taskName task name
	 */
	public function createTask($taskName = '')
	{
		if (!empty($taskName)) {
			session_start();
			$sql = "INSERT INTO xtwo_task (task_name,user_id) VALUES (:task_name,:user_id)";
			$q = $this->conn->prepare($sql);
			$q->execute(
				array(
					':task_name' => $taskName,
					':user_id'   => $_SESSION['authenticated']
				)
			);
			echo json_encode('sucess');
		} else {
			echo json_encode('failure');
		}
	}

	/**
	 * this method load all the task and comment related to the task
	 *
	 * @return JSONObject
	 */

	public function getAllTasks()
	{
		//previous query
		//SELECT task.id as id,task.task_name,com.id as commentId,com.comment FROM xtwo_task as task INNER JOIN xtwo_comment as com ON task.id = com.task_id WHERE task.user_id
		session_start();
		$sql = "SELECT * FROM xtwo_task WHERE user_id='" . $_SESSION['authenticated'] . "' ORDER BY  id DESC ";
		$q = $this->conn->query($sql);
		$fetchedArr = array();
		if ($q->rowCount() > 0) {
			while ($r = $q->fetch()) {
				$commentArr = array();
				if (!empty($r['id'])) {
					$comSql = 'SELECT * FROM `xtwo_comment` WHERE `task_id`= ' . $r['id'];
					$query = $this->conn->query($comSql);
					if ($query->rowCount() > 0) {
						while ($comment = $query->fetch()) {
							$commentArr[] = array(
								'id'      => $comment['id'],
								'comment' => $comment['comment'],
							);
						}
					}
					$fetchedArr[] = array(
						'id'        => $r['id'],
						'task_name' => $r['task_name'],
						'status'    => $r['status'],
						'comments'  => $commentArr
					);
				}
			}
			echo json_encode($fetchedArr);
		} else {
			echo json_encode('failure');
		}
	}

	/**
	 * this method take the comment credentials as a json object and create
	 * comment
	 * @param Array $commentData commentdata and taskid
	 * @return JSONObject
	 */
	public function createComment($commentData)
	{
		if (!empty($commentData)) {
			$sql = "INSERT INTO  xtwo_comment (comment,task_id) VALUES (:comment,:task_id)";
			$q = $this->conn->prepare($sql);
			$q->execute(
				array(
					':comment' => $this->parseUrl($commentData['comment']),
					':task_id' => $commentData['task_id']
				)
			);
		}

	}

	/**
	 * this method take the taskid and status and update it in task table
	 *
	 * @param int $taskId taskid
	 * @param tinyint $status task done or not done marking
	 * @return JSONObject
	 */
	public function updateMark($taskId,$status)
	{
		if (!empty($taskId)) {
			$upMarkSql = "UPDATE `xtwo_task` SET `status`= {$status} WHERE `id`=".$taskId;
			$this->conn->exec($upMarkSql);
			echo json_encode('success');
		}
	}

	/**
	 * This method take the task id delete the task
	 * @param int $taskId task id
	 * @return void
	 */
	public function deleteTask($taskId)
	{
		if (!empty($taskId)) {
			$delSql = "DELETE FROM `xtwo_task` WHERE `id`=" . $taskId;
			$this->conn->exec($delSql);
			echo json_encode('success');
		}
	}

	/**
	 * this method take the comment id and remove the comment
	 * @param $commentId comment id
	 * @return void
	 */
	public function deleteComment($commentId)
	{
		if (!empty($commentId)) {
			$delSql = "DELETE FROM `xtwo_comment` WHERE `id`=" . $commentId;
			$this->conn->exec($delSql);
			echo json_encode('success');
		}
	}

	/**
	 * the method generate the mysql connection
	 * @return void
	 */
	private function mysqlConn()
	{
		$host = $this->settings['host'];
		$dbName = $this->settings['dbname'];
		try {
			$conn = new \PDO("mysql:host=$host;dbname="
				. $dbName, $this->settings['user'], $this->settings['password']);
			// set the PDO error mode to exception
			$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$this->conn = $conn;

		} catch (PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}
	}

	/**
	 * this method take the comment string as parameter and replce the url as
	 * a clickable stirng
	 * @param string  $str comment string
	 *
	 * @return mixed|string
	 */
	protected function parseUrl($str)
	{
		$str = str_replace('www.', 'http://www.', $str);
		$str = preg_replace('|http://([a-zA-Z0-9-./]+)|', '<a href="http://$1">$1</a>', $str);
		$str = preg_replace(
			'/(([a-z0-9+_-]+)(.[a-z0-9+_-]+)*@([a-z0-9-]+.)+[a-z]{2,6})/',
			'<a href="mailto:$1">$1</a>',
			$str
		);
		return $str;
	}
}

