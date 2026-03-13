  if ($pedido['estado'] == 'pendiente') {
                                ?>
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">

                                </span>
                                <?php echo 'Entregado';
                            } elseif ($pedido['estado'] == 'en_preparacion') {
                                ?>
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">

                                </span>
                                <?php echo 'En Preparacion';
                            } elseif ($pedido['estado'] == 'pendiente') {
                                ?>
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">

                                </span>
                                <?php echo 'Pendiente';
                            } elseif ($pedido['estado'] == 'en_camino') {
                                ?>
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">

                                </span>
                                <?php echo 'En Camino';
                            } elseif ($pedido['estado'] == 'cancelado') {
                                ?>
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">

                                </span>
                                <?php echo 'Cancelado';
                            } ?>
