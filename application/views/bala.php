<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta charset="UTF-8">
  <title>乐超超项目</title>
  <script type="text/javascript" src="<?=$src_path ?>common/js/jquery-1.11.0.min.js"></script>
</head>

<body>
<div class="g-mn">
  <div class="g-mnc">
    <!--  正文  -->
    <h5 class="title-txt">首页 > 试用活动管理 > 活动管理</h5>
    <div class="row row-table">
      <form class="rt-head clearfix" action="/trys/lists">
        <select name="field" class="col-sm-1 select">
          <option value="">请选择</option>
          <option value="title" <?php echo $field=='title' ? 'selected' : '';?>>活动名称</option>
          <option value="id" <?php echo $field=='id' ? 'selected' : '';?>>活动ID</option>
        </select>
        <input type="text" placeholder="请输入关键字" name="keyword" class="col-sm-2 input ml5" value=<?php echo $keyword ? $keyword : '';?>>
        <button class="col-sm-1 btn ml5">查询</button>
      </form>
      <table class="rt-table u-table">
        <thead>
          <tr>
            <th>活动ID</th>
            <th>活动名称</th>
            <th>原价(元)</th>
            <th>活动类型</th>
            <th>到店领用期限</th>
            <th>发放份数</th>
            <th>已领取/已使用</th>
            <th>状态</th>
            <th>操作</th>
          </tr>
        </thead>
        <?php foreach( $lists as $list):?>
        <tbody>
          <tr id="<?=$list['id'];?>">
            <td><?php echo $list['id'];?></td>
            <td style="text-align:left;">
              <img style="margin-left:20px;margin-right:5px;" src="<?php echo $this->config->item("domain_img").$list['default_img'];?>" onerror="this.onerror=null;this.src='<?php echo $this->config->item("domain_static")."common/img/default_img/75.png" ?>'" class="img-min" alt="">
              <?php echo $list['title'];?>
            </td>
            <td><?php echo $list['price'];?></td>
            <td><?php echo '体验师专享';?></td>
            <td><?php echo date('Y-m-d', $list['end_time']);?><a class="a-btn-border ml5 J_extend" href="javascript:;" data-time="<?=date('Y-m-d', $list['end_time']);?>">延长</a></td>
            <td><?php echo $list['quantity'];?></td>
            <td><?php echo $list['order_received'] + $list['order_consumed'] + $list['order_expire'] . '/' . $list['order_consumed'];?></td>
            <td><?php echo try_status_name($list['status']);?></td>
            <td>
              <a href="/trys/record?try_id=<?=$list['id']?>">详情</a>
            </td>
          </tr>
        </tbody>
        <?php endforeach; ?>
      </table>
    </div>
    <!--  正文 END -->
  </div>
</div>
</body>

</html>