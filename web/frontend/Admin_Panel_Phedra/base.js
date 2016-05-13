$(document).ready(function () {
    
        $("#fileProject").change(function () {
            
            var file = $('#fileProject').val();
            
            var fileArray = file.split("\\");
            
            var fileName = fileArray[fileArray.length - 1];
            
            if (file !== null) {
                $('.filenameProject').text(fileName);
                
            }
        });
    
    
    
        $("#fileFase1").change(function () {
            
            var file = $('#fileFase1').val();
            
            var fileArray = file.split("\\");
            
            var fileName = fileArray[fileArray.length - 1];
            
            if (file !== null) {
                $('.filenameFase1').text(fileName);
                
            }
        });
    
});