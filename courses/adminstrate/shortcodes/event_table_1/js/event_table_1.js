(function($) {
  
	// The jQuery.aj namespace will automatically be created if it doesn't exist
    	$.widget('administrate.administrate_event_table_1', {
	
		// These options will be used as defaults
		options: { 
			table:				'table',
			filters:			'form',
			categoryOptions:	'#administrate-event-table-category',
			currencyOptions:	'#administrate-currency-select',
			monthOptions:		'#administrate-event-table-month',
			locationOptions:	'#administrate-event-table-location',
			pager:				'#administrate-event-table-pager',
			noRows:				'.administrate-no-rows',
			btn:				'.administrate-btn',
			oddClass:			'administrate-alt',
			pagerFirst:			'.administrate-event-table-pager-first',
			pagerPrevious:		'.administrate-event-table-pager-previous',
			pagerNext:			'.administrate-event-table-pager-next',
			pagerLast:			'.administrate-event-table-pager-last',
			pagerStatus:		'.administrate-event-table-pager-status',
			pagerDisabledClass:	'administrate-event-table-pager-disabled',
			filteredRowClass:	'administrate-event-table-filtered'
		},
		
		//  Initialize widget
		_create: function() {
			//  Save references to objects
			this.table				=	this.element.find(this.options.table);
			this.filters			=	this.element.find(this.options.filters);
			this.categoryOptions	=	$(this.options.categoryOptions);
			this.currencyOptions	=	$(this.options.currencyOptions);
			this.monthOptions		=	$(this.options.monthOptions);
			this.locationOptions	=	$(this.options.locationOptions);
			this.noRows 			=	this.element.find(this.options.noRows);
			this.pager				= 	$(this.options.pager);
			
			//  Save reference to filters form and events
			this.events = this.table.find("tbody").children();
            
			// Show sessions container
			//
			var session_links = this.events.find(".administrate-session-link");
			
			session_links.on( "mouseover", function(e) {
				var widget    = $(this).closest(".administrate-widget");
				var event_id  = $(this).closest("tr").attr("data-event-id");
				var container = $( "#sessions-" + event_id );

				var widget_pos = widget.offset();
				var pos = {left:e.pageX-widget_pos.left, top:e.pageY-widget_pos.top};

				var doc_h = $(document).height();
				var container_w = container.width();
				var container_h = container.height();

				container.css( {"left": (pos.left+20) + "px", "top": (pos.top-100) + "px"} );
				container.show();
			
				if( pos.top + container_h + 200 > doc_h  ) {
					container.css( {"top": (pos.top-container_h+50) + "px"} );
				}
			});

			session_links.on( "mouseout", function(e) {
				var event_id = $(this).closest("tr").attr("data-event-id");
				var container = $( "#sessions-" + event_id );
			container.fadeOut("fast");
			});

			this.table.show();

			//  Only proceed if there are any events in the table
			if (this.events.length > 0) {
			
				//  Add a metaDate parser
				$.tablesorter.addParser({ 
					id: 'startDate', 
					is: function(s) { 
						return false; 
					}, 
					format: function(s, table, cell, cellIndex) { 
						return parseInt($(cell).attr('data-start-date'));
					},
					type: 'numeric' 
				});
				
				//  Initialize table sorter
				this.table.tablesorter({
					widgets: 		['zebra', 'filter'],
					widgetOptions:	{
						zebra: 				['', this.options.oddClass],
						filter_filteredRow:	this.options.filteredRowClass
					}
				});
				
				//  If the pager element exists, initialize it
				if ((this.pager.length > 0) && (this.table.find('tbody').find('tr').length > 0)) {
					this.pager.show();
					this.table.tablesorterPager({
						container:		this.pager,
						fixedHeight:	false,
						size:			parseInt(this.table.attr("data-group-size")),
						output:			'{startRow} - {endRow} / {filteredRows}',
						cssFirst:		this.options.pagerFirst,
						cssPrev:		this.options.pagerPrevious,
						cssNext:		this.options.pagerNext,
						cssLast:		this.options.pagerLast,
						cssPageDisplay:	this.options.pagerStatus,
						cssDisabled:	this.options.pagerDisabledClass
					});
				}
				
				//  Activate the category filter
				this.categoryOptions.change($.proxy(this._filter_table, this));
				
				//  Activate the currency filter
				this.currencyOptions.change($.proxy(this._filter_table, this));
                
				//  Activate the month filter
				this.monthOptions.change($.proxy(this._filter_table, this));
				
				//  Activate the location filter
				this.locationOptions.change($.proxy(this._filter_table, this));
				
				//  Hide the "Go" button since this is all JS-ified
				this.filters.find(this.options.btn).hide();
				
				//  Do the initial filter
				this._filter_table();
			
			//  Otherwise just hide tne entire widget
			} else {

				// Show the 'no rows' text
				this.noRows.show();
			}

			/*
				Switch to mobile layout on container resize
			*/
			var self = this;

			function on_container_resize() {
				var container_width   = self.element.width();
				
				if( container_width > 700 ) {
					// Switch to full layout
					$('.administrate-sort-filter-table thead').show();
					$('.administrate-event-table-course-code').show();
					$('.administrate-event-table-course-name').show();
					$('.administrate-event-table-course-location').show();
					$('.administrate-event-table-date').show();
					$('.administrate-event-table-time').show();
					$('.administrate-event-table-price').show();
					$('.administrate-event-table-registration').show();
					$('.administrate-event-table-mobile').hide();
					$('.administrate-event-table-mobile .slide-register').hide();
					$('.administrate-event-table-registration')
						.removeClass("administrate-event-table-registration-mobile");
				}
				else if( container_width > 400 ) {
					// Switch to mobile layout
					$('.administrate-sort-filter-table thead').hide();
					$('.administrate-event-table-course-code').hide();
					$('.administrate-event-table-course-name').hide();
					$('.administrate-event-table-course-location').hide();
					$('.administrate-event-table-date').hide();
					$('.administrate-event-table-time').hide();
					$('.administrate-event-table-price').hide();
					$('.administrate-event-table-registration').show();
					$('.administrate-event-table-mobile').show();
					$('.administrate-event-table-mobile .slide-register').hide();
					$('.administrate-event-table-registration')
						.addClass("administrate-event-table-registration-mobile");
				}
				else {
					// Switch to small mobile layout
					$('.administrate-sort-filter-table thead').hide();
					$('.administrate-event-table-course-code').hide();
					$('.administrate-event-table-course-name').hide();
					$('.administrate-event-table-course-location').hide();
					$('.administrate-event-table-date').hide();
					$('.administrate-event-table-time').hide();
					$('.administrate-event-table-price').hide();
					$('.administrate-event-table-registration').hide();
					$('.administrate-event-table-mobile').show();
					$('.administrate-event-table-mobile .slide-register').show();
					$('.administrate-event-table-registration')
						.addClass("administrate-event-table-registration-mobile");
				}
			};
            
            //$(window).on("resize", on_container_resize);
            //on_container_resize();
		},
		
		//  Filter events table
		_filter_table: function() {
		
			//  Figure out the filter category
			var filterCategory = false;
			var filterSubcategory = false;
			var selectedValue = this.categoryOptions.val();
			if (selectedValue && (selectedValue.length > 0)) {
				var categories = selectedValue.split(":");
				if (parseInt(categories[1]) === 0) {
					filterCategory = categories[0];	
				} else {
					filterSubcategory = categories[1];	
				}
			}
            
			var filterCurrency = this.currencyOptions.val();
			
			if( !filterCurrency ) {
				filterCurrency = "all";
			}
            
			//  Set the filter months
			var filterMonths = parseInt(this.monthOptions.val());
			
			//  Set the filter location
			var filterLocation = this.locationOptions.val();
			
			//  Loop through events
			var numShown = 0;
			for (var i = 0, numEvents = this.events.length; i < numEvents; ++i) {
			
				//  Save the event and attributes
				var event = $(this.events[i]);
				var eventCategories = event.attr("data-categories").split(",");
				var eventSubcategories = event.attr("data-subcategories").split(",");
				var eventMonths = parseInt(event.attr("data-num-months"));
				var eventLocation = event.attr("data-location");
				var eventCurrencies = event.attr("data-currencies").split(",");
				var eventDefaultCurrency = event.attr("data-event-default-currency");
                
				//  Show the event only if all criteria are met; otherwise hide
				if (
					((!filterCategory && !filterSubcategory) || ($.inArray(filterCategory, eventCategories) > -1) || ($.inArray(filterSubcategory, eventSubcategories) > -1)) && 
					(eventMonths <= filterMonths) &&
					((filterLocation.length == 0) || (eventLocation == filterLocation)) &&
					((filterCurrency=="all") || (eventCurrencies[0]=="all") || ($.inArray(filterCurrency, eventCurrencies) > -1) )
				) {
					event.removeClass(this.options.filteredRowClass);
					event.show();
					++numShown;
				} else {
					event.addClass(this.options.filteredRowClass);
					event.hide();	
				}
				
				// Show active price
				event.find(".administrate-price").each( function() {
					var price = $(this);
					var price_currency = price.attr("data-event-currency");
                    
					if( 
						(price_currency == "all") || 
						( (filterCurrency == "all") && (price_currency == eventDefaultCurrency) ) ||
						(price_currency == filterCurrency)
					){
						price.show();
						if( price_currency != "all") {
							var link = event.find(".administrate-event-table-register-link");
							var href = link.attr("href");
							if(href) {
								var href_currency = href.replace(/event_currency=[A-Z]+$/, "event_currency=" + price_currency );
								link.attr("href", href_currency);
							}
						}
					}
					else {
						price.hide();
					}
				});
			}
			
			//  If no results were shown, display message
			if (numShown == 0) {
				this.noRows.show();	
			} else {
				this.noRows.hide();
			}
			
			//  Force tablesorter to reset
			if (this.pager.length > 0) {
				this.table.trigger('pageSet', 0);
			}
			
		},
		
		// Use the destroy method to reverse everything your plugin has applied
		destroy: function() {

			//  Call parent destroy
			$.Widget.prototype.destroy.call(this);
		
		}

	});
	$('#administrate-event-table-1').administrate_event_table_1();
})(jQuery);
