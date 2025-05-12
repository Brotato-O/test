<!-- main -->
<div class="container">
        <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Cập nhật quyền</h2>
        <div class="container text-bg-light rounded">

            <form action="indexadmin.php?act=updatepq" method="post" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="tenvaitro" class="form-label text-danger">Tên vai trò:</label>
                <input type="text" class="form-control" id="tenvaitro" placeholder="Tên vai trò" name="vaitro_name" value="<?php echo htmlspecialchars($pq_one['vaitro_name']); ?>">
                <input type="hidden" name="vaitro_id" value="<?php echo htmlspecialchars($pq_one['vaitro_id']); ?>">
            </div>
                <div class="mb-3 mt-3">
                <label class="form-label text-danger">Quyền:</label>
                <?php
                // Lấy danh sách quyền từ cơ sở dữ liệu
                $permissions = query_all_permissions(); // Hàm này cần được định nghĩa để lấy tất cả quyền
                $currentPermissions = getCurrentPermissions($pro_one['pro_id']); // Hàm này cần lấy quyền hiện tại của vai trò

                foreach ($permissions as $permission): ?>
                    <div>
                        <input type="checkbox" name="permissions[]" value="<?= $permission['permission_id'] ?>" 
                            <?php if (in_array($permission['permission_id'], $currentPermissions)): ?> checked <?php endif; ?>>
                        <?= $permission['permission_name'] ?>
                    </div>
                <?php endforeach; ?>
            </div>

                <div class="">
                    <button type="submit" class="btn btn-secondary btn-sm" name="updatepq">Cập nhật quyền</button>
                    <button type="reset" class="btn btn-secondary btn-sm">Nhập lại</button>
                    <a href="indexadmin.php?act=qlpq">
                        <button type="button" class="btn btn-secondary btn-sm">Danh sách vai trò</button>
                    </a>
                </div>
            </form>
        </div>
    </div>