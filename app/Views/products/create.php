
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Create Product</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo site_url('product/store'); ?>" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?= old('name') ?>">
                        </div>
                        <div class="mb-3">
                            <label>Price</label>
                            <input type="text" name="price" class="form-control" value="<?= old('price') ?>">
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control"><?= old('price') ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Category</label>
                            <select name="category" class="form-control">
                                <option value="Rings">Rings</option>
                                <option value="Necklaces">Necklaces</option>
                                <option value="Bracelets">Bracelets</option>
                                <option value="Earrings">Earrings</option>
                                <option value="Anklets">Anklets</option>
                                <option value="Bangles">Bangles</option>
                                <option value="Pendants">Pendants</option>
                                <option value="Chains">Chains</option>
                            </select>                       
                        </div>

                         <div class="mb-3">
                            <label>Images</label>
                            <input type="file" name="images[]" multiple class="form-control mt-2">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
