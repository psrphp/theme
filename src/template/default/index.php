{include common/header@psrphp/admin}
<script>
    function change(name) {
        $.ajax({
            type: "POST",
            url: "{echo $router->build('/psrphp/theme/change')}",
            data: {
                name: name
            },
            dataType: "JSON",
            success: function(response) {
                if (response.errcode) {
                    alert(response.message);
                } else {
                    location.reload();
                }
            },
            error: function() {
                alert('发生错误~');
            }
        });
    }

    function del(name) {
        if (confirm('确定删除该主题吗？删除后无法恢复！')) {
            $.ajax({
                type: "POST",
                url: "{echo $router->build('/psrphp/theme/delete')}",
                data: {
                    name: name
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.errcode) {
                        alert(response.message);
                    } else {
                        location.reload();
                    }
                },
                error: function() {
                    alert('发生错误~');
                }
            });
        }
    }
</script>
<div class="container">
    <div class="my-4">
        <div class="h1">主题管理</div>
        <div class="text-muted fw-light">
            <span>主题位于 <code>/theme</code> 目录</span>
            <span>，开发者请阅读<a href="https://github.com/psrphp" target="_blank" class="mx-1">[https://github.com/psrphp]</a>.</span>
        </div>
    </div>
    <div class="d-flex flex-column gap-4">
        {foreach $themes as $theme}
        <div class="d-flex gap-3">
            <div>
                <img src="{echo $theme['thumb']}" class="img-thumbnail" width="130" alt="">
            </div>
            <div class="d-flex flex-column gap-2 flex-grow-1 bg-light p-3">
                <div><span class="fs-6 fw-bold">{$theme['title']?:'-'}</span><sup class="ms-1 text-secondary">{$theme['version']??''}</sup></div>
                <div>{$theme.description}</div>
                <div><code>/theme/{$theme.name}</code> </div>
                <div class="d-flex gap-2">
                    {if in_array($theme['name'], $config->get('theme', []))}
                    <button class="btn btn-sm btn-danger" type="button" onclick="change('{$theme.name}');" data-bs-toggle="tooltip" data-bs-placement="right" title="点击停用该主题">使用中</button>
                    {else}
                    <button class="btn btn-sm btn-primary" type="button" onclick="change('{$theme.name}');" data-bs-toggle="tooltip" data-bs-placement="right" title="点击使用该主题">使用该主题</button>
                    <button class="btn btn-sm btn-warning" type="button" onclick="del('{$theme.name}');" data-bs-toggle="tooltip" data-bs-placement="right" title="删除该主题">删除</button>
                    {/if}
                </div>
            </div>
        </div>
        {/foreach}
    </div>
</div>
{include common/footer@psrphp/admin}