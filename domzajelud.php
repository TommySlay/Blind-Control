<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlindControl-Ajax-test</title>
</head>
<body>

<form id="postForm" method = "post">
    <input type="text" name="name" id="name2">
    <input type="submit" value="Submit">
</form>


<script>
    document.getElementById("postForm").addEventListener('submit',updateDb);

    function updateDb(e){
        e.preventDefault();
    
    var name = document.getElementById('name2').value;
    var params = "name="+name; // možda ide "Stat=" + Stat
    console.log(params);

    var xhr = new XMLHttpRequest();
    xhr.open('POST','roleta_updateData2.php', true);
    xhr.setRequestHeader('Contenet-type','application/x-www-form-urlencoded');

    xhr.onload = function(){
        console.log(this.responseText);
    }

    xhr.send(params);
    }

</script>

</body>
</html>