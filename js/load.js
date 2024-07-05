var dv;
var dv;

function load() {
			var bdy = document.getElementsByTagName('body')[0];
      	var bkg = document.createElement('div');
			bkg.setAttribute('style', 'z-index:1;position:fixed;display:flex;height:100%;width:100%;background-color:#fff;filter:opacity(1)');
      	bkg.setAttribute('id', 'bkg');      
      
   		//var svg = document.createElement('svg');
   		
   		
   		
        var dv = document.createElement('div');
        dv.setAttribute('id', 'dv');        
        dv.setAttribute('style', 'z-index:2;position:relative;margin:auto;width:450px;align-self:center;align-items:center;');
		  var img = document.createElement('img');
		  img.setAttribute('src', 'img/flower.png');
		  img.setAttribute('onload', 'set_pos_abs_center(this);');
		  img.setAttribute('style', 'position:absolute;left:40%;');

		  var dv2 = document.createElement('div');
		  dv2.setAttribute('id', 'dv2');        
        dv2.setAttribute('style', 'width:250px;position:absolute;bottom:-180px;left:32%;');
		  
		  var spn = document.createElement('span');
        spn.setAttribute('class', 'mn');
        spn.setAttribute('style', 'font-family: sans-serif;display:inline-block;font-size: 22px;');
        var txt = document.createTextNode('Processando ');
        spn.append(txt);
        var h3 = document.createElement('h3');
        spn.append(h3);
        dv2.append(spn);
        
        spn = document.createElement('span');
        spn.setAttribute('class', 'mn pt');
		  dv2.append(spn);
		  spn = document.createElement('span');
        spn.setAttribute('class', 'mn pt');
		  dv2.append(spn);
		  spn = document.createElement('span');
        spn.setAttribute('class', 'mn pt');
		  dv2.append(spn);
		  
		  dv.append(img);
		  dv.append(dv2);
		  console.log(bkg.append(dv));
		  bkg.append(dv);
		  bdy.insertBefore(bkg, bdy.childNodes[0]);

		  
		  var spns = document.getElementsByClassName('pt');
        var i =  0; 
        var j;
        var count = 0;
        var n = 14;
        
		  var rst = n*0.1;          
		  var bkcnt= 7;

		  var stl_bkg = bkg.getAttribute('style');
		  var stl = dv.getAttribute('style');
		  var stl2 = dv2.getAttribute('style');
		  
		  function bye() {		  	
		  					dv = document.getElementById('dv');				  			 
				  		   dv2 = document.getElementById('dv2');
				         bkg=document.getElementById('bkg');
				         
		  		 			if(n>0) {
		  		 				rst = n*0.1; 
			               n--;		               
	                     dv.setAttribute('style', stl+'filter:opacity('+rst+')');
	                     dv2.setAttribute('style', stl2+'filter:opacity('+rst+')');
	                
			               if(n%2==0){
			                        bkcnt--;
			                        var rst1=(bkcnt)*0.01;
			                        bkg.setAttribute('style', stl_bkg+'filter:opacity('+rst1+')');
			               }
			               setTimeout(bye, 2**(bkcnt))
				         }
				          else {       
				             	bkg.remove();
				             	dv2.remove();
			                  dv.remove();
				          }
		  }
		  
		  var img_stl = img.getAttribute('style');    			
    	  function gear() {		    	  	         			
				  	      dv = document.getElementById('dv');				  			 
				  		   dv2 = document.getElementById('dv2');
				         bkg=document.getElementById('bkg');
				                   
							i++;							
		               img.setAttribute('style', img_stl+'transform:rotate('+i*0.05+'deg);');  
	                  	                                									
							if(i%101==0) {
						 		if(count%3==0 && count!=0) {
						 			for(j=0;j<3;j++) {
										spns[j].innerHTML = "";	
										count=0;				 			
						 			}
						 		}
						 		else {
						 			spns[count].innerHTML = ".";
						 			count++;
						 		}					 
							}
							console.log(i);
							i==1000 ?
								bye() :
									setTimeout(gear, 1);
			  
	      }
	      gear();
}