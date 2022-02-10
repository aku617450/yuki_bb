<?php

class requestProcess{

  /**
   * Special character avoidance function
   * 特殊文字回避関数
   *
   * @param [array] $request
   * @return array
   */
  function escape($request){
    foreach($request as $key => $val){
      $params[$key] = htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
    }
    return $params;
  }

  function index(){
    require '../model/db.php';
    try{
      $stmt = $pdo->prepare('SELECT * FROM posts');
      $stmt->execute();
      $res = $stmt->fetchAll();
      return $res;
    }catch(Exception $e){
      return array('result' => '失敗', 'message' => 'エラーが発生しました', 'data' => NULL);
    }
  }

  /**
   * Registration function
   * 登録関数
   *
   * @param [array] $request
   * @return array
   */
  function create($request){
    require '../model/db.php';
    $request = $this->escape($request);
    try{
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $pdo->beginTransaction();
      $stmt = $pdo->prepare('INSERT INTO posts (title, content) VALUES (:title, :content)');
      $stmt->bindValue(':title', $request['title'], PDO::PARAM_STR);
      $stmt->bindValue(':content', $request['content'], PDO::PARAM_STR);
      $stmt->execute();
      $pdo->commit();
      $res = $this->index();
      return array('result' => '成功', 'message' => '登録しました', 'data' => $res);
    }catch(Exception $e){
      $pdo->rollBack();
      return array('result' => '失敗', 'message' => 'エラーが発生しました', 'data' => NULL);
    }
  }

  /**
   * Edit function
   * 編集関数
   *
   * @param [Array] $request
   * @return Array
   */
  function edit($request){
    require '../model/db.php';
    $request = $this->escape($request);
    try{
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $pdo->beginTransaction();
      $stmt = $pdo->prepare('UPDATE posts SET title = :title, content = :content WHERE id = :id');
      $stmt->bindValue(':id', $request['id'], PDO::PARAM_INT);
      $stmt->bindValue(':title', $request['title'], PDO::PARAM_STR);
      $stmt->bindValue(':content', $request['content'], PDO::PARAM_STR);
      $stmt->execute();
      $pdo->commit();
      $res = $this->index();
      return array('result' => '成功', 'message' => '更新しました', 'data' => $res);
    }catch(Exception $e){
      $pdo->rollBack();
      return array('result' => '失敗', 'message' => 'エラーが発生しました', 'data' => NULL);
    }
  }

  /**
   * Destroy function
   * 削除関数
   *
   * @param [Array] $request
   * @return Array
   */
  function destroy($request){
    require '../model/db.php';
    $request = $this->escape($request);
    try{
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $pdo->beginTransaction();
      $stmt = $pdo->prepare('DELETE FROM posts WHERE id = :id');
      $stmt->bindValue(':id', $request['id'], PDO::PARAM_INT);
      $stmt->execute();
      $pdo->commit();
      $res = $this->index();
      return array('result' => '成功', 'message' => '削除しました', 'data' => $res);
    }catch(Exception $e){
      $pdo->rollBack();
      return array('result' => '失敗', 'message' => 'エラーが発生しました', 'data' => NULL);
    }
  }

}