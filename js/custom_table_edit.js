$(document).ready(function(){
$('#data_table').Tabledit({
deleteButton: false,
editButton: false,
columns: {
identifier: [0, 'idbarang'],
editable: [[1, 'qty']]
},
hideIdentifier: true,
url: 'live_edit.php'
});
});