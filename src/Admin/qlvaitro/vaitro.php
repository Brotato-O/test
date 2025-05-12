<div class="container">
    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Danh sách vai trò</h2>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-bg-secondary"></th>
                    <th class="text-bg-secondary">Tên vai trò</th>
                    <th class="text-bg-secondary">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listvt as $itemvt): 
                    extract($itemvt); 
                ?>
                <tr>
                    <td><input type="checkbox" name="checkbox[]" value="<?= $vaitro_id ?>"></td>
                    <td><?= htmlspecialchars($vaitro_name) ?></td>
                    <td>
                        <a href="indexadmin.php?act=xoavt&vaitro_id=<?= $vaitro_id ?>" onclick="return confirm('Bạn có chắc muốn xoá ?')">
                            <input class="mb-2 text-bg-danger rounded" type="button" value="Xoá">
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="">
        <button type="button" class="btn btn-secondary btn-sm" onclick="toggleCheckboxes(true)">Chọn tất cả</button>
        <button type="button" class="btn btn-secondary btn-sm" onclick="toggleCheckboxes(false)">Bỏ chọn tất cả</button>
        <button type="button" class="btn btn-secondary btn-sm">Xoá các mục đã chọn</button>
        <a href="indexadmin.php?act=addvt1">
            <button type="button" class="btn btn-secondary btn-sm">Thêm vai trò</button>
        </a>
    </div>
</div>

<script>
    function toggleCheckboxes(checked) {
        const checkboxes = document.querySelectorAll('input[name="checkbox[]"]');
        checkboxes.forEach(cb => cb.checked = checked);
    }
</script>
