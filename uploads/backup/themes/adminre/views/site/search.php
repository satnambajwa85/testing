<script src="<?php echo Yii::app()->theme->baseUrl; ?>/javascript/algoliasearch.min.js"></script>
<style type="text/css">
    form {
        margin: 0;
        padding: 0;
        border: 0;
        outline: 0;
        font-size: 100%;
        vertical-align: baseline;
        background: transparent;
        display: block;
        line-height: normal;
        color: #333;
    }
    .search_box {
        margin: 0px 0 0 0;
        padding: 0 0 0 0;
        position: relative;
        height: 45px;
    }
    #q {
        width: 413px;
        display: block;
        border: 1px solid #cfcfcf;
        color: #000;
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
        -webkit-appearance: none;
        padding: 10px 13px 10px 13px;
        line-height: 23px;
        float: left;
        font-size: 1em;
        background-color: white;
        -webkit-rtl-ordering: logical;
        -webkit-user-select: text;
        cursor: auto;
        margin: 0em;
        border-radius: 4px 0px 0px 4px;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-weight: 300;
    }
    ::-webkit-input-placeholder {
        color: #9f9f9f;
    }
    :-moz-placeholder {
        color: #9f9f9f;
    }
    ::-moz-placeholder {
        color: #9f9f9f;
    }
    :-ms-input-placeholder {
        color: #9f9f9f;
    }
    .search_box #1:focus {
        outline-width: 0px;
        border: 1px solid #999;
    }
    .search_box #q:hover {
        border: 1px solid #999;
    }
    .search_box_shadow {
        -webkit-box-shadow: 0px 0px 2px 0px #2E61E4;
        -moz-box-shadow: 0px 0px 2px 0px #2E61E4;
        box-shadow: 0px 0px 2px 0px #2E61E4;
    }
    .search_box .searchbutton {
        cursor: pointer;
        display: inline-block;
        padding: 0px;
        width: 56px;
        height: 43px;
        margin: 0px 0 0 -1px;
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
        background-color: #FFFFFF;
        border: 1px solid #2182CD;
        text-align: center;
        color: #5588AA;
    }
    [class^="icon-"],
    [class*=" icon-"] {
        display: inline-block;
        margin-top: 10px;
        vertical-align: middle;
    }
    .search_box .searchbutton:hover {
        background-color: white;
        background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, white), color-stop(100%, #9ad9ff));
        background-image: -webkit-linear-gradient(top, white, #9ad9ff);
        background-image: linear-gradient(to bottom, white, #9ad9ff);
        box-shadow: inset 0 1px 0 #75C5E1
    }
    body {
        background-color: #ffffff;
    }
    .panel {
        width: 500px;
        margin-top: 10px;
        margin-left: auto;
        margin-right: auto;
        border: 1px solid #dddddd;
        border-radius: 4px;
        -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
    }
    .panel-heading {
        padding: 10px 15px;
        font-size: 1em;
        background-color: #00B3FF;
        border-bottom: 1px solid #dddddd;
        border-top-right-radius: 3px;
        border-top-left-radius: 3px;
    }
    .bg {
        background-color: #f3f3f3;
    }
    .facets-wrapper {
        float: left;
        width: 20%;
    }
    .hits-wrapper {
        width: 80%;
    }
    #hits {
        padding: 5px 0px;
    }
    .hit {
        cursor: pointer;
        padding: 5px 15px;
    }
    .hit:hover {
        background-color: #e9f0ff;
    }
    em {
        font-style: normal;
        font-weight: bold;
    }
    .grey {
        display: inline;
        color: #888;
    }
    body {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-weight: 300;
    }
    li.refined {
        font-weight: bold;
    }
    @media (max-width: 500px) {
        body {
            margin: 0px;
        }
        .panel {
            margin-top: 0px;
            width: 100%;
        }
        #q {
            width: -moz-calc(100% - 60px);
            width: -webkit-calc(100% - 60px);
            width: calc(100% - 60px);
        }
    }
</style>
<section class="col-lg-12 bg-teal" style="height:5px;">

    <!-- START row -->

    <!--/ END row -->
</section>

<section class="col-lg-12">

    <div class="row">
        <div class="col-lg-12 text-center">
            <h3 class="title light text-grey5 mtb22">Get started by outlining your requirements</h3>
        </div>
    </div>

</section>

<section class="col-lg-12" style="margin-top:20px;">
    <!-- START row -->
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            <div class="col-sm-12">
                <div class="col-sm-12 text-center">
                    <h4 class="title light text-grey9 text-size16 mb20">Access our self-service platform:</h4>
                </div>

                <!-- Social button -->

                <!--/ Social button -->
                <div class="col-sm-12 text-center mb15">
                    <span class="text-muted ">Tell me what's your need </span>
                </div>

                <!-- Search form -->
                <div class="col-sm-8 ">
                    <?php //echo CHtml::dropDownList( 'service', '',CHtml::listData(Services::model()->findAllByAttributes(array("status"=>'1')),'id', 'name'),array('class'=>"form-control",'id'=>"search_dropdown", 'prompt' =>'What help do you want ??','multiple'=>'multiple')); ?>
                    <form action="#" method="get">
                        <input autocomplete="off" class="autocomplete" id="q" placeholder="Start typing" type="text" spellcheck="false" />
                        <div class='searchbutton'>
                            <i class="icon-search icon-large"></i>
                        </div>
                    </form>
					<div style="clear:both;"></div>
                    <div class="facets-wrapper">
                        <h1>Facets</h1>
                        <div id="facets"></div>
                    </div>
                    <div class="hits-wrapper">
                        <h1>Results</h1>
                        <div id="hits"></div>
                    </div>
                </div>
                <!--/ Search form -->
            </div>
        </div>


        <script type="text/javascript">
            $(document).ready(function() {
                $("#search_dropdown").selectize();
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                var refinements = {};
                var $inputfield = $("#q");
                // Replace the following values by your ApplicationID and ApiKey.
                var algolia = new AlgoliaSearch('1WOVNJD6UB', '0d11d15f709e865633945d41790f5525');
                // replace YourIndexName by the name of the index you want to query.
                var index = algolia.initIndex('test_drive');

                 $inputfield.keyup(function() {
					  search();
					}).focus();
                $(".searchbutton").on("keyup", function() {
                    search();
                    $inputfield.focus();
                });

                window.toggleRefine = function(refinement) {
                    refinements[refinement] = !refinements[refinement];
                    search();
                }

                function search() {
                    var filters = [];
                    for (var refinement in refinements) {
                        if (refinements[refinement]) {
                            filters.push(refinement);
                        }
                    }
                    index.search($inputfield.val(), searchCallback, {
                        facets: '*',
                        facetFilters: filters
                    });
                }

                function searchCallback(success, content) {
                    if (content.query != $inputfield.val()) {
                        // do not consider out-dated queries
                        return;
                    }
                    if (content.hits.length == 0 || content.query.trim() === '') {
                        // no results
                        $('#hits').empty();
                        $('#facets').empty();
                        return;
                    }

                    // Scan all hits and display them
                    var hits = '';
                    for (var i = 0; i < content.hits.length; ++i) {
                        var hit = content.hits[i];

                        // For this hit, display all property that have a least one word highlighted (matchLevel = full or partial)
                        hits += '<div class="hit">';
                        for (var propertyName in hit._highlightResult) {
                            var el = hit._highlightResult[propertyName];
                            if (Object.prototype.toString.call(el) !== '[object Array]' && el.matchLevel !== 'none') {
                                hits += '<div class="attribute"><span>' + propertyName.substr(0, 1).toUpperCase() +
                                    propertyName.substr(1) + ": </span>" + el.value + "</div>";
                            }
                        }
                        hits += '</div>';
                    }
                    $('#hits').html(hits);

                    // Scan all facets and display them
                    var facets = '';
                    for (var facet in content.facets) {
                        facets += '<h4>' + facet + '</h4>';
                        facets += '<ul>';
                        var values = content.facets[facet];
                        for (var value in values) {
                            var refinement = facet + ':' + value;
                            facets += '<li class="' + (refinements[refinement] ? 'refined' : '') + '">' +
                                '<a href="#" onclick="toggleRefine(\'' + refinement + '\'); return false">' + value + '</a> (' + values[value] + ')' +
                                '</li>';
                        }
                        facets += '</ul>';
                    }
                    $('#facets').html(facets);
                }
            });
        </script>
    </div>
</section>