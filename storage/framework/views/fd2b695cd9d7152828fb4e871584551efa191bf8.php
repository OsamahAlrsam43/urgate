<?php if($item->total() > 9): ?>
    <!-- Start custom-pagination -->
    <div class="custom-pagination d-flex align-items-center justify-content-md-end justify-content-center">
        <!-- Start nav -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item <?php echo e(($item->currentPage() == 1) ? ' disabled' : ''); ?>">
                    <a class="page-link" href="<?php echo e($item->url($item->currentPage()-1)); ?>"><?php echo app('translator')->getFromJson("alnkel.pagination-previous"); ?></a>
                </li>
                <?php for($i = 1;$i <= $item->total();$i++): ?>
                    <li class="page-item <?php echo e($i === $item->currentPage() ? 'active' : ''); ?>">
                        <a class="page-link" href="<?php echo e($item->url($i)); ?>"><?php echo e($i); ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php echo e(($item->currentPage() == $item->lastPage()) ? ' disabled' : ''); ?>">
                    <a class="page-link" href="<?php echo e($item->url($item->currentPage()+1)); ?>"><?php echo app('translator')->getFromJson("alnkel.pagination-next"); ?></a>
                </li>
            </ul>
        </nav>
        <!-- End nav -->
    </div>
    <!-- End custom-pagination -->
<?php endif; ?>