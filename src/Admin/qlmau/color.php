
            
    <!-- main -->
    <div class="container">
                    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Quản lý màu</h2>

                        <div class="table-responsive">
                          <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <Th class="text-bg-secondary"></Th>
                                  <th class="text-bg-secondary">Id</th>
                                  <th class="text-bg-secondary">Tên màu</th>
                                  <th class="text-bg-secondary">Mã màu</th>
                                  <Th class="text-bg-secondary">Thao tác</Th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php foreach ($listcolor as $itemcolor) { 
                              extract($itemcolor);
                              ?>
                                <tr>
                                  <td><input type="checkbox" name="checkbox" id=""></td>
                                  <td><?= $color_id  ?></td>
                                  <td><?= $color_name ?></td>
                                  <td><?= $color_ma ?></td>
                                  <td>
                                    
                                      <a href="indexadmin.php?act=xoacolor&color_id=<?php echo $color_id ?>"><input type="button"  class="mb-2 text-bg-danger rounded" onclick="return confirm('Bạn có chắc muốn xoá ?')" name="" value="Xoá" id=""></a>
                               
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
                          <a href="indexadmin.php?act=addcolor1">
                            <button type="button" class="btn btn-secondary btn-sm">Thêm màu</button>
                        </a>
                        </div>
                </div>
           
    
