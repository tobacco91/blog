var tab = document.querySelectorAll(".manage_list p");
		var act = document.querySelectorAll(".right div");
		for(var i = 0;i < tab.length;i++){
			tab[i].index = i;
			tab[i].addEventListener('click',function(){
				for(i = 0;i < tab.length;i++){
					tab[i].className = '';
					act[i].className = 'hide';
				}
			tab[this.index].className = 'act';
			act[this.index].className = '';
			})
		}