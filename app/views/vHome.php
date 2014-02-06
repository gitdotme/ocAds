<!-- home header layer begin //-->
            <header id="homeHeader">
                <!-- header logo begin //-->
                <div class="headerLogo">
                    <p><a href="<?php echo baseURL(); ?>" title="<?php echo Config::get('siteName', 'seo'); ?>"><img src="<?php echo baseURL('assets/img/logo-large.gif'); ?>" alt="<?php echo Config::get('siteName', 'seo'); ?>"></a></p>
                </div>
                <!-- header logo end //-->
                <!-- header text start //-->
                <div class="headerText">
                    <h1><?php echo $headingLayout; ?></h1>
                </div>
                <!-- header text end //-->
                <!-- header bar begin //-->
                <div class="headerBar">
                    <!-- search form begin //-->
                    <form method="get" action="<?php echo baseURL(Config::get('searchLink', 'seo')); ?>" class="searchForm">
                        <ul>
                            <li>
                                <p><span>What?</span></p>
                                <p><input type="text" name="query" class="searchQuery" placeholder="Search for..."></p>
                            </li>
                            <?php if ( ! Config::get('searchType', 'search')): ?>
                            <li>
                                <p><span>Which?</span></p>
                                <p>
                                    <select name="type" class="searchType">
                                        <?php if (isset($params)): ?>
                                        <option value="car"<?php echo selectedVal('car', $params['type']); ?>>Cars</option>
                                        <option value="boat"<?php echo selectedVal('boat', $params['type']); ?>>Boats</option>
                                        <option value="moto"<?php echo selectedVal('moto', $params['type']); ?>>Motorcycles</option>
                                        <option value="atv"<?php echo selectedVal('atv', $params['type']); ?>>ATVs</option>
                                        <option value="rv"<?php echo selectedVal('rv', $params['type']); ?>>RVs</option>
                                        <option value="trailer"<?php echo selectedVal('trailer', $params['type']); ?>>Trailers</option>
                                        <?php else: ?>
                                        <option value="car">Cars</option>
                                        <option value="boat">Boat and Yatchs</option>
                                        <option value="moto">Motorcycles</option>
                                        <option value="atv">ATVs</option>
                                        <option value="rv">RVs</option>
                                        <option value="trailer">Trailers</option>
                                        <?php endif; ?>
                                    </select>
                                </p>
                            </li>
                            <?php endif; ?>
                            <?php if ( ! Config::get('searchCountry', 'search')): ?>
                            <li>
                                <p><span>Where?</span></p>
                                <p>
                                    <select name="country" class="searchCountry">
                                        <?php if (isset($params)): ?>
                                        <option value="us"<?php echo selectedVal('us', $params['country']); ?>>United States</option>
                                        <option value="ca"<?php echo selectedVal('ca', $params['country']); ?>>Canada</option>
                                        <option value="uk"<?php echo selectedVal('uk', $params['country']); ?>>United Kingdom</option>
                                        <?php else: ?>
                                        <option value="us">United States</option>
                                        <option value="ca">Canada</option>
                                        <option value="uk">United Kingdom</option>
                                        <?php endif; ?>
                                    </select>
                                </p>
                            </li>
                            <?php endif; ?>
                            <li>
                                <p><span>&nbsp;</span></p>
                                <p><input type="submit" value="Search" class="searchButton"></p>
                            </li>
                        </ul>
                    </form>
                    <!-- search form end //-->
                </div>
                <div class="clear">&nbsp;</div>
                <!-- header bar end //-->
            </header>
            <!-- home header layer end //-->
            <!-- content layer start //-->
            <section id="content">
                <?php if (Config::get('searchType', 'search')): ?>
                    <?php if ($makes): ?>
                    <!-- makes begin //-->
                    <div class="homeLatest">
                        <h2><?php echo ucwords(Config::get('searchType', 'search')); ?> Makes</h2>
                        <ul>
                            <?php if ($makes): ?>
                                <?php foreach ($makes as $make): ?>
                                <li><a href="<?php echo tagLink($make->title); ?>" title="<?php echo ucwords(strtolower(filterText($make->title))); ?>"><?php echo ucwords(strtolower(filterText($make->title))); ?></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <!-- makes end //-->
                    <?php endif; ?>
                <?php else: ?>
                    <?php if ($carMakes): ?>
                    <!-- car makes begin //-->
                    <div class="homeLatest">
                        <h2>Cars Makes</h2>
                        <ul>
                            <?php if ($carMakes): ?>
                                <?php foreach ($carMakes as $carMake): ?>
                                <li><a href="<?php echo tagLink($carMake->title); ?>" title="<?php echo ucwords(strtolower(filterText($carMake->title))); ?>"><?php echo ucwords(strtolower(filterText($carMake->title))); ?></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <!-- car makes end //-->
                    <?php endif; ?>
                    <?php if ($boatMakes): ?>
                    <!-- boat makes begin //-->
                    <div class="homeLatest">
                        <h2>Boats Makes</h2>
                        <ul>
                            <?php if ($boatMakes): ?>
                                <?php foreach ($boatMakes as $boatMake): ?>
                                <li><a href="<?php echo tagLink($boatMake->title); ?>" title="<?php echo ucwords(strtolower(filterText($boatMake->title))); ?>"><?php echo ucwords(strtolower(filterText($boatMake->title))); ?></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <!-- boat makes end //-->
                    <?php endif; ?>
                    <?php if ($motoMakes): ?>
                    <!-- moto makes begin //-->
                    <div class="homeLatest">
                        <h2>Motorcycles Makes</h2>
                        <ul>
                            <?php if ($motoMakes): ?>
                                <?php foreach ($motoMakes as $motoMake): ?>
                                <li><a href="<?php echo tagLink($motoMake->title); ?>" title="<?php echo ucwords(strtolower(filterText($motoMake->title))); ?>"><?php echo ucwords(strtolower(filterText($motoMake->title))); ?></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <!-- moto makes end //-->
                    <?php endif; ?>
                    <?php if ($atvMakes): ?>
                    <!-- atv makes begin //-->
                    <div class="homeLatest">
                        <h2>ATVs Makes</h2>
                        <ul>
                            <?php if ($atvMakes): ?>
                                <?php foreach ($atvMakes as $atvMake): ?>
                                <li><a href="<?php echo tagLink($atvMake->title); ?>" title="<?php echo ucwords(strtolower(filterText($atvMake->title))); ?>"><?php echo ucwords(strtolower(filterText($atvMake->title))); ?></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <!-- atv makes end //-->
                    <?php endif; ?>
                    <?php if ($rvMakes): ?>
                    <!-- rv makes begin //-->
                    <div class="homeLatest">
                        <h2>RVs Makes</h2>
                        <ul>
                            <?php if ($rvMakes): ?>
                                <?php foreach ($rvMakes as $rvMake): ?>
                                <li><a href="<?php echo tagLink($rvMake->title); ?>" title="<?php echo ucwords(strtolower(filterText($rvMake->title))); ?>"><?php echo ucwords(strtolower(filterText($rvMake->title))); ?></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <!-- rv makes end //-->
                    <?php endif; ?>
                    <?php if ($trailerMakes): ?>
                    <!-- trailer makes begin //-->
                    <div class="homeLatest">
                        <h2>Trailers Makes</h2>
                        <ul>
                            <?php if ($trailerMakes): ?>
                                <?php foreach ($trailerMakes as $trailerMake): ?>
                                <li><a href="<?php echo tagLink($trailerMake->title); ?>" title="<?php echo ucwords(strtolower(filterText($trailerMake->title))); ?>"><?php echo ucwords(strtolower(filterText($trailerMake->title))); ?></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <!-- trailer makes end //-->
                    <?php endif; ?>
                <?php endif; ?>
                <?php if ($latestTags OR $randomTags): ?>
                <!-- latest search begin //-->
                <div class="homeLatest">
                    <h2>Latest Searches</h2>
                    <ul>
                        <?php if ($latestTags): ?>
                            <?php foreach ($latestTags as $latestTag): ?>
                            <li><a href="<?php echo tagLink($latestTag->tag); ?>" title="<?php echo filterText($latestTag->tag); ?>"><?php echo filterText($latestTag->tag); ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php if ($randomTags): ?>
                            <?php foreach ($randomTags as $randomTag): ?>
                            <li><a href="<?php echo tagLink($randomTag->tag); ?>" title="<?php echo filterText($randomTag->tag); ?>"><?php echo filterText($randomTag->tag); ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
                <!-- latest search end //-->
                <?php endif; ?>
            </section>
            <!-- content layer end //-->