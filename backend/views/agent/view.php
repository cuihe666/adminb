<?php
$this->title = '合伙人详情';
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">当前位置：首页 > 合伙人管理 > 合伙人详情</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <tbody>
                        <tr>
                            <td>公司名称:</td>

                            <td><?php echo $data['company_name'] ? $data['company_name'] : '暂无' ?></td>
                        </tr>
                        <tr>
                            <td>纳税识别号:</td>

                            <td><?php echo $data['tax_num'] ? $data['tax_num'] : '暂无' ?></td>
                        </tr>

                        <tr>
                            <td>开户银行:</td>

                            <td><?php echo $data['name'] ? $data['name'] : '暂无' ?></td>
                        </tr>
                        <tr>
                            <td>户名:</td>

                            <td><?php echo $data['company_name'] ? $data['company_name'] : '暂无' ?></td>
                        </tr>
                        <tr>
                            <td>银行账号:</td>

                            <td><?php echo $data['account_number'] ? $data['account_number'] : '暂无' ?></td>
                        </tr>
                        <tr>
                            <td>对公/对私:</td>

                            <td><?php echo $data['type'] == 0 ? '对公' : '对私' ?></td>
                        </tr>
                        <tr>
                            <td>联系邮箱:</td>

                            <td><?php echo $data['company_email'] ? $data['company_email'] : '暂无' ?></td>
                        </tr>
                        <tr>
                            <td>公司地址:</td>
                            <td>
                                <?php echo $data['company_address'] ? $data['company_address'] : '暂无' ?>
                            </td>


                        </tr>


                        </tbody>

                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->


        </div>
