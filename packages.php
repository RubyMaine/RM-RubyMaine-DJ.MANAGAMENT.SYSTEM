<h1 class="text-center"><i class="fas fa-cubes"></i> Наши пакеты </h1>
<hr class="border-light">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="input-group mb-2">
                <input type="search" id="search" class="form-control form-control-border" placeholder=" Пакет поиска здесь... ">
                <div class="input-group-append">
                    <button type="button" class="btn btn-sm border-0 border-bottom btn-default">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="list-group" id="package-list">
    <?php 
        $package = $conn->query("SELECT * FROM `package_list` where `status` = 1 order by `name` asc");
        while($row = $package->fetch_assoc()):
    ?>
    <div class="text-decoration-none list-group-item rounded-0 package-item">
        <a class="d-flex w-100 text-light" href="#package_<?= $row['id'] ?>" data-toggle="collapse">
            <div class="col-11">
                <h3 class="truncate-1" title="<?= ucwords($row['name']) ?>"><b><?= ucwords($row['name']) ?></b></h3>
            </div>
            <div class="col-1 text-right">
                <i class="fa fa-plus collapse-icon"></i>
            </div>
        </a>
        <div class="collapse" id="package_<?= $row['id'] ?>">
            <hr class="border-light">
            <div class="mx-3"><span class="fa fa-tags"></span> <?= number_format($row['price'],2) ?></div>
            <div class="mx-3"><?= html_entity_decode($row['description']) ?></div>
        </div>
    </div>
    <?php endwhile; ?>
    <?php if($package->num_rows < 1): ?>
        <center><span class="text-muted"> Пакет пока не указан. </span></center>
    <?php endif; ?>
        <div id="no_result" style="display:none"><center><span class="text-muted"> Пакет пока не указан. </span></center></div>
    </div>
</div>
<script>
    $(function(){
        $('.collapse').on('show.bs.collapse', function () {
            $(this).parent().siblings().find('.collapse').collapse('hide')
            $(this).parent().siblings().find('.collapse-icon').removeClass('fa-plus fa-minus')
            $(this).parent().siblings().find('.collapse-icon').addClass('fa-plus')
            $(this).parent().find('.collapse-icon').removeClass('fa-plus fa-minus')
            $(this).parent().find('.collapse-icon').addClass('fa-minus')
        })
        $('.collapse').on('hidden.bs.collapse', function () {
            $(this).parent().find('.collapse-icon').removeClass('fa-plus fa-minus')
            $(this).parent().find('.collapse-icon').addClass('fa-plus')
        })

        $('#search').on("input",function(e){
            var _search = $(this).val().toLowerCase()
            $('#package-list .package-item').each(function(){
                var _txt = $(this).text().toLowerCase()
                if(_txt.includes(_search) === true){
                    $(this).toggle(true)
                }else{
                    $(this).toggle(false)
                }
                if($('#package-list .package-item:visible').length <= 0){
                    $("#no_result").show('slow')
                }else{
                    $("#no_result").hide('slow')
                }
            })
        })
    })
</script>
