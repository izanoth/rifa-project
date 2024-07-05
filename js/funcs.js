
function rot(element) { 
        var stl = element.getAttribute('style');
        while(!document.getElementsByClassName('pt')) {
        		setTimeout(rot, 10, element);
        }
        var spns = document.getElementsByClassName('pt');
       console.log(spns);
        var i =  0; 
        var j;
        var count = 0;
        
        function gear() {
			       i++;
                element.setAttribute('style', stl+'transform:rotate('+i*0.05+'deg);');                									
					 if(i%101==0) {
					 		if(count%3==0 && count!=0) {
					 			for(j=0;j<3;j++) {
									spns[j].innerHTML = "";	
									count=0;				 			
					 			}
					 		}
					 		else {
					 			console.log('ok');
					 			spns[count].innerHTML = ".";
					 			count++;
					 		}					 
					 }
                setTimeout(gear, 1);
        }
        gear();
}



function set_pos_abs_center(element) {       
		  var parentnode = element.parentNode;;
		  //var parent_width = parentnode.getBBox().width;     <<<<<<<<<<<<< 
        var img_wd = parseInt(element.width);
        var stl = element.getAttribute('style');
        var rsn = img_wd/450;
        var pos = 50-((100*rsn)/2);       
        element.setAttribute('style', stl+'left:'+pos+'%'); 
}  