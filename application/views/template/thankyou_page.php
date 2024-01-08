<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thank you page</title>

    <script>
            $(document).ready(function () {
                
            $('#btn_close').click( function(){
                window.close();
                window.opener.location.reload();
                
            });
        
        
            });
            
            
        </script>

</head>
<body>
        <div class="container">
            <h2 style="text-align: center;">Success</h2><br>
            <button id="btn_close" class="btn btn-warning btn-block">ปิดหน้าต่างนี้</button>
        </div>
        
    </body>
</html>