$("#reload").click(function reload() {
$value1 = $("#word").val();
$value2 = $("#endingNumber").val();
const button = $("#helper");
button.load("../components/helper.php?word='" + $value1 + "'&endingNumber=" + $value2);
});