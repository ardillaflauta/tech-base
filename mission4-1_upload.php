	<?php
	
	//データベースに接続
	$dsn='mysql:dbname='データベース名';host=localhost';
	$user='ユーザー名';
	$password='パスワード';
	$pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE =>PDO::ERRMODE_WARNING));
			
	//テーブルを作成
	$sql = "CREATE TABLE IF NOT EXISTS bulletinboard5"
	." ("
	. "id INT auto_increment,"
	. "name char(32),"
	. "comment TEXT,"
	. "date datetime,"
	. "password char(32),"
	. "primary key(id)"
	.");";
	$stmt = $pdo->query($sql);
	
	
	
	
	
	
	//編集機能　1.フォームに回答を入れる
	if(!empty($_POST['edit'])){
		$editnum = $_POST['edit'];
		
			$sql = 'SELECT * FROM bulletinboard5';
			$stmt = $pdo->query($sql);
			$results = $stmt->fetchAll();
			foreach ($results as $row){
				
				if($editnum ==$row['id'] && $_POST['editpass'] == $row['password']){
				 
					$editmode = $row['id'];
			 		$editname = $row['name'];
			 		$editcomment = $row['comment'];
			 		$editpass = $row['password'];
			 	}else{
			 	continue;
			 	}
			}
			
			
	}	
		
		
	?>


<html>
<html lang = “ja”>
	<head>
		<meta charset="utf-8">
		<title>mission4-1</title>
	</head>
			
	<body>	
	
	<!-- アクションをpostに設定 -->
		<form action="mission_4-1.php" method="post">
		<p>
		<!-- フォームの名前記入欄を作成--> 
		<h2>
		<input type="text" name='name' placeholder=名前 value="<?php echo $editname?>">
		
		<!-- フォームのコメント記入欄を作成--> 
		<br>
		<input type="text" name='comment' placeholder= コメント value="<?php echo $editcomment?>"> 
		<br>
		<!--ここに数字入ったら編集モード、あとで隠す-->
		<input type="hidden" name='editmode' value="<?php echo $editmode?>"> 
		<!--パスワード入力-->
		<input type="text" name='password' placeholder=パスワード value="<?php echo $editpass?>"> 
		<!--送信ボタンを作成 --> 
		<input type="submit" value="送信">
		<br><br>
		<!--削除欄作成-->
		<input type="text" name='delete' placeholder=削除対象番号>
		<br>
		<input type="text" name='deletepass' placeholder=パスワード>
		<input type="submit" value="削除">
		<br><br>
		<!--編集欄作成-->
		<input type="text" name='edit' placeholder=編集対象番号>
		<br>
		<input type="text" name='editpass' placeholder=パスワード>
		<input type="submit" value="編集">
		
		</h2>
		</p>
		</form>
	<?php
		
	//編集機能　2.編集実行
	if(!empty($_POST['editmode'])){
		$editnum2 = $_POST['editmode'];
		
			$sql = 'SELECT * FROM bulletinboard5';
			$stmt = $pdo->query($sql);
			$results = $stmt->fetchAll();
			foreach ($results as $row){
				
				if($editnum2 ==$row['id'] ){
				 	$id = $_POST['editmode'];
				 	
				 	$date = new DateTime(); 
					$date = $date->format('Y-m-d H:i:s'); 
				 	
				 	$sql = $pdo -> prepare("INSERT INTO bulletinboard5 (name, comment,date,password) VALUES (:name, :comment, :date, :password)");
					
					$sql -> bindParam(':name', $name, PDO::PARAM_STR);
					$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
					$sql -> bindParam(':password', $password, PDO::PARAM_STR);
					$sql -> bindParam(':date', $date, PDO::PARAM_STR);
					
					$editname =$_POST['name'];
					$editcomment =$_POST['comment']	;
					$editpassword =$_POST['password'];
					$sql -> execute();
				 
					echo $id.' ';
					echo $editname.' ';
					echo $editcomment.' ';
					echo $date.'<br>';
					
			 	}else{
			 		echo $row['id'].' ';
			 		echo $row['name'].' ';
			 		echo $row['comment'].' ';
			 		echo $row['date'].'<br>';
			 		
			 	}
			}
		
			
	
	//投稿機能
	}elseif(!empty($_POST['name'])&&($_POST['comment'])&&($_POST['password'])){
			$date = new DateTime(); 
			$date = $date->format('Y-m-d H:i:s'); 
			
			$sql = $pdo -> prepare("INSERT INTO bulletinboard5 (id,name, comment, date, password) VALUES (:id,:name, :comment, :date, :password)");
			$sql -> bindParam(':id', $id, PDO::PARAM_STR);
			$sql -> bindParam(':name', $name, PDO::PARAM_STR);
			$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
			$sql -> bindParam(':date', $date, PDO::PARAM_STR);
			$sql -> bindParam(':password', $password, PDO::PARAM_STR);
			$name =$_POST['name'];
			$comment =$_POST['comment']	;
			$password =$_POST['password'];
			$sql -> execute();
			
			$sql = 'SELECT * FROM bulletinboard5';
			$stmt = $pdo->query($sql);
			$results = $stmt->fetchAll();
			foreach ($results as $row){
				 //$rowの中にはテーブルのカラム名が入る
				echo $row['id'].' ';
			 	echo $row['name'].' ';
			 	echo $row['comment'].' ';
			 	echo $row['date'].'<br>';
			 	
			}
	
	//削除機能
	}elseif(!empty($_POST['delete'])){
		$deletenum = $_POST['delete'];
		
			
			
			$sql = 'SELECT * FROM bulletinboard5';
			$stmt = $pdo->query($sql);
			$results = $stmt->fetchAll();
			foreach ($results as $row){
				$deletenum = $_POST['delete'];
		
			if($deletenum == $row['id'] && $_POST['deletepass'] == $row['password']){
				
		
				$id = $deletenum;
				$sql = 'delete from bulletinboard5 where id=:id';
				$stmt = $pdo->prepare($sql);
				$stmt->bindParam(':id', $id, PDO::PARAM_INT);
				$stmt->execute();
	
				$sql = 'SELECT * FROM bulletinboard5';
				$stmt = $pdo->query($sql);
				$results = $stmt->fetchAll();
				foreach ($results as $row){
			 		//$rowの中にはテーブルのカラム名が入る
			 		echo $row['id'].' ';
			 		echo $row['name'].' ';
					echo $row['comment'].' ';
					echo $row['date'].'<br>';
					
			 	
				}
			}elseif(!$_POST['deletepass'] == $row['password']){
				echo "パスワードが違います";
			}
			}
			
	
	};
	
	
	
	
?>


	</body>
</html>