  <section class="panel panel-default">
    <header class="panel-heading">
      Eğitmen Tablosu
    </header>
    <div class="row wrapper">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control input-s-sm inline v-middle">
          <option value="0">-- Durum --</option>
          <option value="1">Aktif</option>
          <option value="2">Eksik Tamamlayan</option>
          <option value="3">İncelenmede</option>
        </select>
        <button class="btn btn-sm btn-default">Göster</button>                
      </div>

    </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th width="20"></th>
            <th>İlköğretim Takviye</th>
            <th>Lise Takviye</th>
            <th>Üniversite Takviye</th>
            <th>Sınava Hazırlık</th>
            <th>Yabancı Dil</th>
            <th>Bilgisayar</th>
            <th>Müzik</th>
            <th>Spor</th>
            <th>Sanat</th>
            <th>Dans</th>
            <th>Kişisel Gelişim</th>
            <th>Direksiyon</th>
            <th>Özel Eğitim</th>
            <th>Oyun ve Hobi</th>
          </tr>
        </thead>
        <tbody>
		  <?foreach($cities as $city):?>        
          <tr>
            <td><strong><?=$city->title?></strong></td>
            <td><?=$city->count_real[7]?> / <?=$city->count_virtual[7]?></td>
            <td><?=$city->count_real[8]?> / <?=$city->count_virtual[8]?></td>
            <td><?=$city->count_real[9]?> / <?=$city->count_virtual[9]?></td>
            <td><?=$city->count_real[10]?> / <?=$city->count_virtual[10]?></td>
            <td><?=$city->count_real[11]?> / <?=$city->count_virtual[11]?></td>
            <td><?=$city->count_real[12]?> / <?=$city->count_virtual[12]?></td>
            <td><?=$city->count_real[13]?> / <?=$city->count_virtual[13]?></td>
            <td><?=$city->count_real[14]?> / <?=$city->count_virtual[14]?></td>
            <td><?=$city->count_real[15]?> / <?=$city->count_virtual[15]?></td>
            <td><?=$city->count_real[16]?> / <?=$city->count_virtual[16]?></td>
            <td><?=$city->count_real[17]?> / <?=$city->count_virtual[17]?></td>
            <td><?=$city->count_real[18]?> / <?=$city->count_virtual[18]?></td>
            <td><?=$city->count_real[19]?> / <?=$city->count_virtual[19]?></td>
            <td><?=$city->count_real[20]?> / <?=$city->count_virtual[20]?></td>
          </tr>
          <?endforeach;?>
        </tbody>
      </table>
    </div>

  </section>