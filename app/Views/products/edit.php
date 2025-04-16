<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Create Product</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo site_url('product/update/'.$product['id']); ?>" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?=$product['id']?>">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?=$product['name']?>">
                        </div>
                        <div class="mb-3">
                            <label>Price</label>
                            <input type="text" name="price" class="form-control" value="<?=number_format($product['price'])?>">
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control"><?=$product['description']?></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Category</label>
                            <select name="category" class="form-control">
                                <option value="Rings" <?= $product['category'] == 'Rings' ? 'selected' : '' ?>>Rings</option>
                                <option value="Necklaces" <?= $product['category'] == 'Necklaces' ? 'selected' : '' ?>>Necklaces</option>
                                <option value="Bracelets" <?= $product['category'] == 'Bracelets' ? 'selected' : '' ?>>Bracelets</option>
                                <option value="Earrings" <?= $product['category'] == 'Earrings' ? 'selected' : '' ?>>Earrings</option>
                                <option value="Anklets" <?= $product['category'] == 'Anklets' ? 'selected' : '' ?>>Anklets</option>
                                <option value="Bangles" <?= $product['category'] == 'Bangles' ? 'selected' : '' ?>>Bangles</option>
                                <option value="Pendants" <?= $product['category'] == 'Pendants' ? 'selected' : '' ?>>Pendants</option>
                                <option value="Chains" <?= $product['category'] == 'Chains' ? 'selected' : '' ?>>Chains</option>
                            </select>                  
                        </div>

                         <div class="mb-3">
                            <label>Images</label>
                            <input type="file" name="images[]" multiple class="form-control mt-2">
                        </div>
                        <div class="row">
                                <?php foreach ($product_image as $img): ?>
                                    <div class="col-2 text-center mb-2" id="<?php echo $img->id;?>">
                                        <img src="/uploads/<?= esc($img->images) ?>" width="80" class="img-thumbnail">
                                            <a type="submit" id="deletepimage" data-image="<?php echo $img->images;?>" data-id="<?php echo $img->id;?>" data-proid = "<?=$product['id'];?>" data-confirm="Are you sure to delete this item?" class="btn btn-danger btn-sm mt-1">Delete</a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('body').on('click', '#deletepimage', function (event) {

            event.preventDefault();

var choice = confirm($(this).attr('data-confirm'));
            var imageId = $(this).data('id');
            var productId = $(this).data('proid');
         
            var deleteButton = $(this);
            if (choice) {

                $.ajax({
                    url: '<?= base_url()."/product/deleteImage"; ?>',
                    type: 'POST',
                    data: { image_id: imageId,product_id: productId },
                    success: function (response) {
                        if (response.success) {

                            var element = $("#"+imageId);
                            if (element.is("div")) {
                                element.remove();
                            }
                        } else {
                            console.error('Error deleting image');
                        }
                    },
                    error: function () {
                        console.error('Ajax request failed');
                    }
                });
            }
        });
    });
</script>