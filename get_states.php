<?php
require_once("dbController.php");
$db_handle = new DBController();

if(!empty($_POST["language_id"])) {

  $query ="SELECT * FROM state WHERE lang_id = '" . $_POST["language_id"] . "'";
  
  $results = $db_handle->runQuery($query);
 
?>
  <option value="">Select State</option>
<?php
  foreach($results as $state) {
?>
  <option value="<?php echo $state["state_id"]; ?>"><?php echo $state["name"]; ?></option>
<?php
  }
}
?>