/**
 * Created by ylsc on 16-8-8.
 */

/**
 * 校验分类列表的表单
 * @type {any}
 */
var createForm = $('.createForm').validate({
    rules:{
        cateName:{
            required:true,
            maxlength:20
        },
        asName:{
            required:true,
            maxlength:20
        },
        seoTitle:{
            required:true,
            maxlength:20
        },
        seoName:{
            required:true,
            maxlength:20
        },
        seoDesc:{
            required:true,
            maxlength:40
        }
    },
    messages:{
        cateName:{
            required:'请输入分类名称',
            maxlength:'长度超出最大范围'
        },
        asName:{
            required:'请输入分类别名',
            maxlength:'长度超出最大范围'
        },
        seoTitle:{
            required:'请输入分类seo标题',
            maxlength:'长度超出最大范围'
        },
        seoName:{
            required:'请输入分类seo名称',
            maxlength:'长度超出最大范围'
        },
        seoDesc:{
            required:'请输入seo描述',
            maxlength:'长度超出最大范围'
        }
    }

});

/**
 * 校验标签列表
 * @type {any}
 */
var tagForm = $('.tagForm').validate({
    rules:{
        tagName:{
            required:true,
            maxlength:20
        }
    },
    messages:{
        tagName:{
            required:'请输入标签名称',
            maxlength:'标签长度超出'
        }
    }
});

/**
 * 写文章表单
 * @type {any}
 */
var articleForm = $('.articleForm').validate({
    rules:{
        title:{
            required:true,
            maxlength:50
        },
        category:{
            required:true,
            min:1
        },
        tag:{
            required:true
        }
    },
    messages:{
        title:{
            required:'请输入标题',
            maxlength:'已超出范围'
        },
        category:{
            required:'请选择分类',
            min:'请选择分类'
        },
        tag:{
            required:'请输入标签'
        }
    }
});