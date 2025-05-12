
            
    <!-- main -->
    <div class="container">
                    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Quản thương hiệu</h2>

                        <div class="table-responsive">
                          <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <Th class="text-bg-secondary"></Th>
                                  <th class="text-bg-secondary">Id</th>
                                  <th class="text-bg-secondary">Tên thương hiệu</th>
                                  <th class="text-bg-secondary">Mô tả</th>
                                  <Th class="text-bg-secondary">Thao tác</Th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php foreach ($listbrand as $itembrand) { 
                              extract($itembrand);
                              ?>
                                <tr>
                                  <td><input type="checkbox" name="checkbox" id=""></td>
                                  <td><?= $id  ?></td>
                                  <td><?= $ten_thuong_hieu ?></td>
                                  <td><?= $mo_ta ?></td>
                                  <td>
                                    <a href="indexadmin.php?act=suabrand&brand_idsua=<?php echo $id?>" class="mb-2"><input class="mb-2 text-bg-secondary rounded" type="button" name="" value="Sửa" id=""></a>
                                      <a href="indexadmin.php?act=xoabrand&id=<?php echo $id ?>"><input type="button"  class="mb-2 text-bg-danger rounded" onclick="return confirm('Bạn có chắc muốn xoá ?')" name="" value="Xoá" id=""></a>
                               
                                  </td>
                                </tr>
                              <?php  } ?>
                              </tbody>
                            </table>
                        </div>
                        <div class="">
                          <button type="button" class="btn btn-secondary btn-sm ">Chọn tất cả</button>
                          <button type="button" class="btn btn-secondary btn-sm">Bỏ chọn tất cả</button>
                          <button type="button" class="btn btn-secondary btn-sm">Xoá các mục đã chọn</button>
                          <a href="indexadmin.php?act=addbrand1">
                            <button type="button" class="btn btn-secondary btn-sm">Thêm thương hiệu</button>
                        </a>
                        </div>
                </div>
           
    
