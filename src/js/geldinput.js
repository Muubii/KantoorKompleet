document.addEventListener("DOMContentLoaded", function(event) {
    const invoervelden = document.querySelectorAll('.geldInput');
console.log(invoervelden)
    invoervelden.forEach(function(invoer) {

        invoer.addEventListener('input', function() {
            let komma = false;
            let nk = 0;
            let newUserInvoer = "";
            let userInvoer = invoer.value;
            const waardes = "0123456789,";
            const arrwaardes = waardes.split("");

            for(var i = 0; i < userInvoer.length && i < 5; i++ ){
                if(arrwaardes.includes(userInvoer[i])){
                    
                
                    if(userInvoer[i] == ","){
                        if(!komma){
                            komma = true;
                            newUserInvoer+=userInvoer[i];
                        }        
                    }else{
                        if(komma){
                            newUserInvoer+=userInvoer[i];
                            nk++;
                            if(nk > 1){
                                break;
                            }
                            
                        }else{    
                            newUserInvoer+=userInvoer[i];
                        }  
                    }             
                } 

                // if(userInvoer[i] == "," && userInvoer[i + 1] == null){
                //     newUserInvoer += "00";
                //     komma = true;
                // }

            }
            invoer.value = newUserInvoer;

        });

        invoer.addEventListener('blur', function(){
            let userInvoer = invoer.value;
            if(userInvoer.split("").includes(",")){
                let index =  userInvoer.split("").indexOf(",");
                if(userInvoer[index + 1] == null){
                    userInvoer += "00";
                    invoer.value = userInvoer;
                } else if(userInvoer[index + 2] == null){
                    userInvoer += "0";
                    invoer.value = userInvoer;
                }
            } else{
                if(userInvoer.length > 0){
                    userInvoer+= ",00";
                    invoer.value = userInvoer;
                }
            }
            
        })
    });
});
