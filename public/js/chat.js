(function(){
  
  var chat = {
    messageToSend: '',
    chatScroll: '',
    loadMessages: true,
    templateResponse: '',
    contextResponse: {},
    init: function() {
      this.cacheDOM();
      this.bindEvents();
      this.scrollToBottom();
      
      this.$hasWriting.hide();
      
      if(loadedMessages < 20)
      this.$loadMoreLink.hide();
    },
    cacheDOM: function() {
      this.$chatHistory = $('.chat-history');
      this.$button = $('button');
      this.$textarea = $('#message-to-send');
      this.$chatHistoryList =  this.$chatHistory.find('ul');
      this.$hasWriting = $('#hasWriting');
      this.$loadMoreLink = $('#loadMoreLink');
    },
    bindEvents: function() {
      this.$loadMoreLink.on('click', this.loadMore.bind(this));
      this.$button.on('click', this.send.bind(this));
      this.$textarea.on('keyup', this.sendEnter.bind(this));
    },

    add: function(theMessage, theTime, theUser)
    {
        templateResponse = Handlebars.compile( $("#message-template").html());
        contextResponse = { 
          messageOutput: theMessage,
          time: theTime,
          user: theUser
        };
    },
        
    response: function(theMessage, theTime, theUser)
    {
        templateResponse = Handlebars.compile( $("#message-response-template").html());
        contextResponse = { 
          response: theMessage,
          time: theTime,
          user: theUser
        };	    
    },
    
    send: function() 
    {
		this.messageToSend = this.$textarea.val();			

		if (this.messageToSend.trim() !== '') 
		{
			$.post(base_url + 'messages/add',{counterpartId: counterpartId, message: this.messageToSend}, function(response)
			{
				var res = $.parseJSON(response);
				if(res.success == true)
				{
					chat.add(chat.messageToSend, res.time, messageUser);

			        setTimeout(function() {
			          chat.$chatHistoryList.append(templateResponse(contextResponse));
			          chat.scrollToBottom();
			          chat.$textarea.val('');
			        }.bind(this), 1500);
				} else {
				    alert(res.message);
				}
			});			
		}
    },
    
    sendEnter: function(event) {
        // enter was pressed
        if (event.keyCode === 13) {
          this.send();
        }
    },
    scrollToBottom: function() {
        setTimeout(function() {
       this.$chatHistory.scrollTop(this.$chatHistory[0].scrollHeight);
        }.bind(this), 500);       
    },
    scrollToTop: function() {
        setTimeout(function() {
       this.$chatHistory.scrollTop(0);
        }.bind(this), 500);       
    },    
    getCurrentTime: function() {
      return new Date().toLocaleTimeString().
              replace(/([\d]+:[\d]{2})(:[\d]{2})(.*)/, "$1$3");
    },
    
    loadMore: function()
    {
		this.loadMessages = false;
	    
		$.post(base_url + 'messages/loadmore/'+counterpartId+'/'+loadedMessages, {}, function(response)
		{
			var res = $.parseJSON(response);
			if(res.length > 0)
			{
				for(var key in res)
				{
					if(res[key].to_uid == counterpartId)
					{
						chat.add(res[key].message, res[key].time, messageUser);
					} else {
						chat.response(res[key].message, res[key].time, counterpartUser);
					}
			        chat.$chatHistoryList.prepend(templateResponse(contextResponse));
			          
			        setTimeout(function() {
			          chat.scrollToTop();
			        }.bind(chat), 1500);       						
				}
				chat.loadMessages = true;
				loadedMessages = loadedMessages + 20;
				
			} else {
				chat.$loadMoreLink.hide();
				chat.loadMessages = false;
				jgrowl("Üzgünüz, daha fazla mesaj bulunamadı.", 'red');
			}	    				
		});		    
    }
    
  };
  
  chat.init();
  
  var searchFilter = {
    options: { valueNames: ['name'] },
    init: function() {
      var userList = new List('people-list', this.options);
      var noItems = $('<li id="no-items-found">Sonuç bulunamadı</li>');
      
      userList.on('updated', function(list) {
        if (list.matchingItems.length === 0) {
          $(list.list).append(noItems);
        } else {
          noItems.detach();
        }
      });
    }
  };
  
  searchFilter.init();
	  
})();

