@servers(['web' => 'root@114.215.154.238'])

@task('deploy')
    cd /data/wwwroot/blog/laravel-5-myblog
    git pull origin master
@endtask
