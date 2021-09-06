		const filterizr = new Filterizr('.filter-container', {
  			animationDuration: 0.5,
			  callbacks: { 
			    //onFilteringStart: function() { alert('filterezéskor jatszodik le') },
			    //onFilteringEnd: function() { },
			    //onShufflingStart: function() { alert('ez akkor, amikor a kepek atmozdulni kezdenek') },
			    //onShufflingEnd: function() { alert('ez akkor, amikor a kepek atmozdultak') },
			    //onSortingStart: function() { alert('ez akkor, amikor asc desc nmegy neki') },
			    //onSortingEnd: function() {  alert('ez akkor, amikor asc desc vege neki') }
			  },
			  // elemenkent ennyi a delay, nem osszesen
			  //delay: 100,
			  //delayMode: 'progressive',

			  easing: 'ease-out',
			  // a kezdeti filterezés. Lehet pl web is.
			  filter: 'all',

			  // az elemek, melyek eppen nincsenek kivalasztva...
			  filterOutCss: {
			    opacity: 0,
			    //transform: 'scale(0.5)'
			  },

			  // az elemek, melyek eppen ki vannak valasztva
			  filterInCss: {
			    opacity: 1,
			    //transform: 'scale(0.95)'
			  },

			  // a GRID elemei között
			  gutterPixels: 10,


		});