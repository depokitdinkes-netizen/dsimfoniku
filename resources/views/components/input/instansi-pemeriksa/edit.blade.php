<div class="input-group">
    <label for="instansi-pemeriksa">Instansi Pemeriksa</label>
    <select name="instansi-pemeriksa" id="instansi-pemeriksa" class="select select-bordered" required>
        <option value="" disabled>Pilih Instansi Pemeriksa</option>
        <option value="Dinas Kesehatan" @if(($form_data['instansi-pemeriksa'] ?? '')=='Dinas Kesehatan' ) selected @endif>Dinas Kesehatan</option>
        <option value="Puskesmas" @if(($form_data['instansi-pemeriksa'] ?? '')=='Puskesmas' ) selected @endif>Puskesmas</option>
    </select>
</div>
