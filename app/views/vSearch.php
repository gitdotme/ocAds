<!-- home header layer begin //-->
            <header id="searchHeader">
                <!-- header logo begin //-->
                <div class="headerLogo">
                    <p><a href="<?php echo baseURL(); ?>" title="<?php echo Config::get('siteName', 'seo'); ?>"><img src="<?php echo baseURL('assets/img/logo.gif'); ?>" alt="<?php echo Config::get('siteName', 'seo'); ?>"></a></p>
                </div>
                <!-- header logo end //-->
                <!-- header bar begin //-->
                <div class="headerBar">
                    <!-- search form begin //-->
                    <form method="get" action="<?php echo baseURL(Route::get_config('searchLink', 'route')); ?>" class="searchForm">
                        <ul>
                            <li>
                                <p><input type="text" name="query" class="searchQuery" placeholder="Search for..."></p>
                            </li>
                            <?php if ( ! Config::get('searchType', 'search')): ?>
                            <li>
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
                                        <option value="boat">Boat and Yachts</option>
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
                                <p><input type="submit" value="Search" class="searchButton"></p>
                            </li>
                        </ul>
                    </form>
                    <!-- search form end //-->
                </div>
                <!-- header bar end //-->
            </header>
            <!-- home header layer end //-->
            <!-- content layer begin //-->
            <section id="content">
                <!-- search title begin //-->
                <header id="searchTitle">
                    <h1><?php echo filterText($headingLayout); ?></h1>
                    <div class="rssLink">
                        <p><a href="<?php echo searchLink($params, FALSE, NULL, TRUE); ?>" title="RSS Feed"><i class="rssIcon"></i> RSS Feed</a></p>
                    </div>
                </header>
                <!-- search title end //-->
                <!-- search filter begin //-->
                <aside id="searchFilter">
                    <h2>Filter your search</h2>
                    <form id="filterForm" method="get" action="<?php echo baseURL(Route::get_config('searchLink', 'route')); ?>">
                        <?php if ( ! Config::get('searchKeyword', 'search')): ?>
                        <div class="filterPart">
                            <label for="fQuery">Search for</label>
                            <input type="text" name="query" id="fQuery" value="<?php echo filterText($params['query']); ?>" class="inputText">
                        </div>
                        <?php endif; ?>
                        <div class="filterRangePart">
                            <label for="fYear">Year</label>
                            <input id="fYear" type="text" name="fYear" value="<?php echo $yearMin; ?>;<?php echo $yearMax; ?>">
                            <input type="hidden" name="year_min" id="fYearMin" value="">
                            <input type="hidden" name="year_max" id="fYearMax" value="">
                        </div>
                        <div class="filterRangePart">
                            <label for="fPrice">Price</label>
                            <input id="fPrice" type="text" name="fPrice" value="<?php echo $priceMin; ?>;<?php echo $priceMax; ?>">
                            <input type="hidden" name="price_min" id="fPriceMin" value="">
                            <input type="hidden" name="price_max" id="fPriceMax" value="">
                        </div>
                        <div class="filterRangePart">
                            <label for="fMileage">Mileage</label>
                            <input id="fMileage" type="text" name="fMileage" value="<?php echo $mileageMin; ?>;<?php echo $mileageMax; ?>">
                            <input type="hidden" name="mileage_min" id="fMileageMin" value="">
                            <input type="hidden" name="mileage_max" id="fMileageMax" value="">
                        </div>
                        <div class="filterPart">
                            <label for="fCondition">Condition</label>
                            <select name="condition" id="fCondition" class="inputSelect">
                                <option value=""<?php echo selectedVal('', $params['condition']); ?>>All</option>
                                <option value="1"<?php echo selectedVal('1', $params['condition']); ?>>New</option>
                                <option value="2"<?php echo selectedVal('2', $params['condition']); ?>>Used</option>
                            </select>
                        </div>
                        <div class="filterPart">
                            <label for="fColor">Color</label>
                            <select name="color" id="fColor" class="inputSelect">
                                <option value=""<?php echo selectedVal('', $params['color']); ?>>All</option>
                                <option value="black"<?php echo selectedVal('black', $params['color']); ?>>Black</option>
                                <option value="blue"<?php echo selectedVal('blue', $params['color']); ?>>Blue</option>
                                <option value="brown"<?php echo selectedVal('brown', $params['color']); ?>>Brown</option>
                                <option value="gold"<?php echo selectedVal('gold', $params['color']); ?>>Gold</option>
                                <option value="green"<?php echo selectedVal('green', $params['color']); ?>>Green</option>
                                <option value="gray"<?php echo selectedVal('gray', $params['color']); ?>>Gray</option>
                                <option value="orange"<?php echo selectedVal('orange', $params['color']); ?>>Orange</option>
                                <option value="pink"<?php echo selectedVal('pink', $params['color']); ?>>Pink</option>
                                <option value="purple"<?php echo selectedVal('purple', $params['color']); ?>>Purple</option>
                                <option value="red"<?php echo selectedVal('red', $params['color']); ?>>Red</option>
                                <option value="silver"<?php echo selectedVal('silver', $params['color']); ?>>Silver</option>
                                <option value="tan"<?php echo selectedVal('tan', $params['color']); ?>>Tan</option>
                                <option value="white"<?php echo selectedVal('white', $params['color']); ?>>White</option>
                                <option value="yellow"<?php echo selectedVal('yellow', $params['color']); ?>>Yellow</option>
                            </select>
                        </div>
                        <div class="filterPart">
                            <label for="fLocation">Location</label>
                            <input type="text" name="location" id="fLocation" value="<?php echo filterText($params['location']); ?>" class="inputText">
                        </div>
                        <div class="filterPart centered">
                            <button class="inputSubmit">Search</button>
                        </div>
                    </form>
                </aside>
                <!-- search filter end //-->
                <!-- search results begin //-->
                <section id="searchResults">
                    <?php if ($items): ?>
                    <!-- search results begin //-->
                    <ul>
                        <?php foreach ($items as $item): ?>
                        <!-- search results loop begin //-->
                        <li>
                            <div class="resultHead">
                                <div class="resultTitle">
                                    <h2><a href="<?php echo itemLink($item->hash); ?>" title="<?php echo filterText($item->title); ?>" rel="nofollow"><?php echo filterText($item->title); ?></a></h2>
                                </div>
                                <?php if ($item->price): ?>
                                <div class="resultPrice">
                                    <p><?php echo showPrice($item->price, $item->currency); ?></p>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="resultLocation">
                                <p><?php echo filterText($item->location); ?></p>
                            </div>
                            <div class="resultContain">
                                <?php if ($item->picture): ?>
                                <div class="resultPhoto">
                                    <p><a href="<?php echo itemLink($item->hash); ?>" title="<?php echo filterText($item->title); ?>" rel="nofollow"><img class="lazy" data-original="<?php echo filterText($item->picture); ?>" alt="<?php echo filterText($item->title); ?>"></a></p>
                                </div>
                                <?php endif; ?>
                                <div class="resultContent">
                                    <p><?php echo filterText(substrText($item->content, Config::get('searchDescLimit', 'limit'), TRUE)); ?></p>
                                    <div class="resultMake">
                                        <p><a href="<?php echo modelLink($item->make, $item->model); ?>" title="<?php echo filterText($item->make); ?> <?php echo filterText($item->model); ?>"><?php echo filterText($item->make); ?> <?php echo filterText($item->model); ?></a> <span><?php echo showDate($item->time); ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- search results loop end //-->
                        <?php endforeach; ?>
                    </ul>
                    <!-- search results end //-->
                    <?php else: ?>
                    <div class="noResult">
                        <p>There are no matches for this search right now.</p>
                        <p>Suggestions for expanding your search:</p>
                        <ul>
                            <li>- Is your keyword spelled correctly?</li>
                            <li>- You could try different filtering options.</li>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <?php if ($latestTags OR $randomTags): ?>
                    <!-- example search begin //-->
                    <div class="exampleSearches">
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
                    <!-- example search end //-->
                    <?php endif; ?>
                    <!-- search pagina begin //-->
                    <?php echo $pagination; ?>
                    <!-- search pagina end //-->
                </section>
                <!-- search results end //-->
                <!-- search right begin //-->
                <aside id="searchRight">
                    <!-- search order begin //-->
                    <div class="searchOrder">
                        <form method="get" action="#">
                            <label for="fOrder">Order by:</label>
                            <select name="order" id="fOrder" data-route="<?php echo Route::get_config('searchLink', 'route'); ?>">
                                <option value="<?php echo makeParams($params, TRUE, array('order' => 1)); ?>"<?php echo selectedVal('1', $params['order']); ?>>Date (recent)</option>
                                <option value="<?php echo makeParams($params, TRUE, array('order' => 2)); ?>"<?php echo selectedVal('2', $params['order']); ?>>Date (oldest)</option>
                                <option value="<?php echo makeParams($params, TRUE, array('order' => 3)); ?>"<?php echo selectedVal('3', $params['order']); ?>>Price (lowest)</option>
                                <option value="<?php echo makeParams($params, TRUE, array('order' => 4)); ?>"<?php echo selectedVal('4', $params['order']); ?>>Price (highest)</option>
                                <option value="<?php echo makeParams($params, TRUE, array('order' => 5)); ?>"<?php echo selectedVal('5', $params['order']); ?>>Relevance</option>
                            </select>
                        </form>
                    </div>
                    <!-- search order end //-->
                    <!-- social links begin //-->
                    <div class="socialLinks">
                        <p><a href="http://facebook.com/share.php?u=<?php echo searchLink($params); ?>"><i class="facebookIcon"></i> Share on Facebook</a></p>
                        <p><a href="http://twitter.com/intent/tweet?text=<?php echo searchLink($params); ?>"><i class="twitterIcon"></i> Share on Twitter</a></p>
                    </div>
                    <!-- social links end //-->
                    <!-- other links begin //-->
                    <div class="otherLinks">
                        <?php echo $adLayout; ?>
                        
                    </div>
                    <!-- other links end //-->
                </aside>
                <!-- search right end //-->
            </section>
            <!-- content layer end //-->