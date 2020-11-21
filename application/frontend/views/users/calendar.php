<section class="margin-top-30 margin-bottom-30" ng-controller="MyWidgetCtrl" ng-init="init(<?=htmlspecialchars(json_encode(user_meta($this->session->userdata('user_id'))))?>)">
	<div class="my-container" ng-controller="CalendarCtrl" ng-init="init(<?=htmlspecialchars(json_encode(user_meta($this->session->userdata('user_id'))))?>)">
		<h2 class="margin-bottom-10">Canlı Ders Haftalık Müsaitlik Takvimi</h2>
		<p>Aşağıdaki takvim canlı ders müsaitliğinizi göstermektedir. Müsaitlik tarihlerinizde değişiklik yapmak için düzenle butonuna tıklayınız.</p>
			<div class="row">	
			    <div class="col-md-12 text-center">


	                <ttc-availability
	                    do-render="true"
	                    scenario="calendar"
	                    exception-data="model.user.user_meta_availability_exceptions"
	                    availability-data="model.user.user_meta_availability"
	                    user-id="{{usermodel.id}}">
	                </ttc-availability>

					<div class="clearfix"></div>
	                <a class="btn btn-orange pull-left" href="#" data-toggle="modal" data-target="#calendar-modal">Düzenle</a>
	                
	                
					<div class="modal fade" id="calendar-modal" tabindex="-1" role="dialog" aria-labelledby="expertTermsLabel" aria-hidden="true">
					  <div class="modal-dialog large">
					    <div class="modal-content">
					      <div class="modal-header">
						  	<h5 class="modal-title">Canlı Ders Haftalık Müsaitlik Takvimi</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
								<span aria-hidden="true">&times;</span>
							</button>
					      </div>
					      <div class="modal-body">
							    <h2>Haftalık Müsaitlik</h2>
							    <p>Aşağıdaki takvimden ders verebileceğiniz saatleri seçerek haftalık müsaitlik takviminizi oluşturunuz.</p>
							
							    <ttc-availability
							        do-render="true"
							        scenario="availability"
							        availability-data="model.user.user_meta_availability"
							        user-id="{{usermodel.id}}"
							        show-legend="false">
							    </ttc-availability>
							
							    <div class="spacer"></div>
							    <div class="spacer"></div>
							
							    <h3>Hariç Tutulanlar</h3>
							    <p>Aşağıdaki takvimden bazı haftanın bazı saatlerinde ders alınmasını istemiyorsanız işaretleyiniz.</p>
							
							    <ttc-availability
							        do-render="true"
							        scenario="exception"
							        exception-data="model.user.user_meta_availability_exceptions"
							        availability-data="model.user.user_meta_availability"
							        user-id="{{usermodel.id}}">
							    </ttc-availability>
					      </div>
					      <div class="modal-footer">
						    <button class="btn btn-orange btn-sm pull-right" ng-click="saveAvailability()" ng-disabled="model.isSaving">Kaydet</button>
						    <button class="btn btn-link btn-dismiss pull-right" data-dismiss="modal">İptal</button>	        
					      </div>
					    </div><!-- /.modal-content -->
					  </div><!-- /.modal-dialog -->
					</div><!-- /.modal -->	




			    </div>
			</div>
	</div>
	
	
</section>  



<script type="text/javascript" src="<?=base_url('public/js/ttc-calendar.js')?>"></script>