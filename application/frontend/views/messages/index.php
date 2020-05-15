<script>
	var counterpartId = <?=$message_counterpart->id?>;
	var messageUser = '<?=$this->session->userdata('user_firstname')?> <?=$this->session->userdata('user_lastname')?>';
	var counterpartUser = '<?=$message_counterpart->firstname?> <?=$message_counterpart->lastname?>';
	var loadedMessages = <?=count($chat_messages)?>;
</script>
<link rel="stylesheet" href="<?=base_url('public/css/chat.css')?>">

<div class="chat-container">
<div class="people-list" id="people-list">
  <div class="search">
    <input type="text" placeholder="Arama..." />
    <i class="fa fa-search"></i>
  </div>
  
  <?if(!empty($message_users)):?>
  <ul class="list">
	  
	<?foreach($message_users as $message_user):?>
	<a href="<?=site_url('messages/'.$message_user->counterpart->id)?>">
		<li class="clearfix<?if($this->uri->segment(2) == $message_user->counterpart->id):?> active<?endif;?>">
			<img src="<?if(isset($message_user->counterpart->avatar)):?><?=base_url($message_user->counterpart->avatar)?><?else:?><?=base_url('public/img/user-avatar.png')?><?endif;?>" />
			<div class="about">
				<div class="name"><?=$message_user->counterpart->firstname?> <?=$message_user->counterpart->lastname?></div>
				<!--
				<div class="status">
					<i class="fa fa-circle online"></i> online
				</div>
				-->
				<div class="new"><?if(!empty($message_user->total) && $this->uri->segment(2) != $message_user->to_uid):?><?=$message_user->total?> <?endif;?>yeni mesaj<?if(empty($message_user->total) || $this->uri->segment(2) == $message_user->to_uid):?> yok<?endif;?></div>
			</div>
		</li>
	</a>
	<?endforeach;?>
                      
  </ul>
  <?endif;?>
</div>

<div class="chat">
  <div class="chat-header clearfix">
    <img src="<?if(isset($message_counterpart->avatar)):?><?=base_url($message_counterpart->avatar)?><?else:?><?=base_url('public/img/user-avatar.png')?><?endif;?>" />
    
    <div class="chat-about">
      <div class="chat-with"><?=$message_counterpart->firstname?> <?=$message_counterpart->lastname?></div>
      <div class="chat-num-messages"><?if($message_counterpart->online == 1):?><i class="fa fa-circle online"></i> Çevrimiçi<?else:?>En son <?=nicetime($message_counterpart->lastactive)?> görüldü<?endif;?></div>
    </div>
    <i class="fa fa-star"></i>
  </div> <!-- end chat-header -->
  
  <div class="chat-history">

  	<?if($chat_messages >= 20):?>
	<div class="hasLoading text-center" id="hasLoading">
		<a href="javascript:void(0)" id="loadMoreLink">Daha eski</a>
	</div>
	<?endif;?>
		  
    <ul>
	    <?if(!empty($chat_messages)):?>        
		    <?foreach(array_reverse($chat_messages) as $key => $chat_message):?>
		    	<?if($chat_message->from_uid == $this->session->userdata('user_id')):?>
				<li class="clearfix">
					<div class="message-data align-right">
						<span class="message-data-time" ><?=$chat_message->time?></span> &nbsp;
						<span class="message-data-name" ><?=$this->session->userdata('user_firstname')?> <?=$this->session->userdata('user_lastname')?></span>
					</div>
					<div class="message other-message float-right">
						<?=$chat_message->message?>
					</div>
				</li>		  
				<?else:?>  
				<li>
					<div class="message-data">
						<span class="message-data-name"><?=$message_counterpart->firstname?> <?=$message_counterpart->lastname?></span>
						<span class="message-data-time"><?=date('d.m.Y H:i:s', $chat_message->date)?></span>
					</div>
					<div class="message my-message">
						<?=$chat_message->message?>
					</div>
				</li>	
				<?endif;?>			
		    <?endforeach;?>
	    <?endif;?>
    </ul>

	<div id="hasWriting">
		<i class="fa fa-circle fa-pulse online"></i>
		<i class="fa fa-circle fa-pulse online" style="color: #AED2A6"></i>
		<i class="fa fa-circle fa-pulse online" style="color:#DAE9DA"></i>
	</div>
		        
  </div> <!-- end chat-history -->
  
  <div class="chat-message clearfix">
    <textarea name="message-to-send" id="message-to-send" placeholder ="Mesajınızı buraya yazınız" rows="3"></textarea>
    <!--
    <i class="fa fa-file-o"></i> &nbsp;&nbsp;&nbsp;
    <i class="fa fa-file-image-o"></i>
    -->
    
    <button>Gönder</button>

  </div> <!-- end chat-message -->
  
</div> <!-- end chat -->
</div>

<script id="message-template" type="text/x-handlebars-template">
  <li class="clearfix">
    <div class="message-data align-right">
      <span class="message-data-time" >{{time}}</span> &nbsp;
      <span class="message-data-name" >{{user}}</span>
    </div>
    <div class="message other-message float-right">
      {{messageOutput}}
    </div>
  </li>
</script>

<script id="message-response-template" type="text/x-handlebars-template">
  <li>
    <div class="message-data">
      <span class="message-data-name">{{user}}</span>
      <span class="message-data-time">{{time}}</span>
    </div>
    <div class="message my-message">
      {{response}}
    </div>
  </li>
</script>

<script src='http://cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.0/handlebars.min.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js'></script>
<script  src="<?=base_url('public/js/chat.js')?>"></script>