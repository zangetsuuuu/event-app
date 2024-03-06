<nav aria-label="Page navigation" class="animate__animated animate__fadeInUp animate__delay-1s">
    <ul class="pagination pagination-sm justify-content-center">
        <?php if ($totalPages > 1): ?>
            <li class="page-item <?= $currentPage <= 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?= $currentPage <= 1 ? '#' : '?page=' . ($currentPage - 1); ?>"
                    aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $currentPage ? 'active' : ''; ?>">
                    <a class="page-link" href="<?= $i == $currentPage ? '#' : '?page=' . $i; ?>">
                        <?= $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?= $currentPage >= $totalPages ? '#' : '?page=' . ($currentPage + 1); ?>"
                    aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>