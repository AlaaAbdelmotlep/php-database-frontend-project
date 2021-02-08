<!--delete-process.php-->
<?php
require_once "config.php";
$sql = "DELETE FROM pap_view WHERE papid='" . $_GET["papid"] . "' ";
if (mysqli_query($link, $sql)) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . mysqli_error($link);
}
mysqli_close($link);
?>
