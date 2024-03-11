Hammer.plugins.fakeMultitouch();

		function getIndexForValue(elem, value) {
			for (var i=0; i<elem.options.length; i++)
				if (elem.options[i].value == value)
					return i;
		}

		function pad(number) {
			if ( number < 10 ) {
				return '0' + number;
			}
			return number;
		}

		function update(datetime) {
			$("#date").drum('setIndex', datetime.getDate()-1); 
			$("#month").drum('setIndex', datetime.getMonth()); 
			$("#fullYear").drum('setIndex', getIndexForValue($("#fullYear")[0], datetime.getFullYear())); 
			$("#hours").drum('setIndex', datetime.getHours()); 
			$("#minutes").drum('setIndex', datetime.getMinutes()); 			
		}

		$(document).ready(function () {
			$("select.date").drum({
				onChange : function (elem) {
					var arr = {'date' : 'setDate', 'month' : 'setMonth', 'fullYear' : 'setFullYear', 'hours' : 'setHours', 'minutes' : 'setMinutes'};
					var date = new Date();
					for (var s in arr) {
						var i = ($("form[name='date'] select[name='" + s + "']"))[0].value;
						eval ("date." + arr[s] + "(" + i + ")");
					}
					date.setSeconds(0);
					update(date);

					var format = date.getFullYear() + '-' + pad( date.getMonth() + 1 ) + '-' + pad( date.getDate() ) + ' ' + pad( date.getHours() ) + ':' + pad( date.getMinutes() );

					$('.date_header .selection').html(format);
				}
			});
			update(new Date());
		});