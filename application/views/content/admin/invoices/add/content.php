<div class='panel'>
  <header>
    <h2>新增請款</h2>
    <a href='<?php echo base_url ($uri_1);?>' class='icon-x'></a>
  </header>

  <form class='form' method='post' action='<?php echo base_url ($uri_1);?>' enctype='multipart/form-data'>

    <div class='row n2'>
      <label>請款</label>
      <div>
        <label class='switch'>
          <input type='checkbox' name='is_finished'<?php echo isset ($posts['is_finished']) && ($posts['is_finished'] == Invoice::IS_FINISHED) ? ' checked' : '';?> />
          <span></span>
        </label>
      </div>
    </div>

    <div class='row n2'>
      <label>* 負責人</label>
      <div>
        <select name='user_id'>
    <?php if ($users = User::all (array ('select' => 'id, name'))) {
            foreach ($users as $user) { ?>
              <option value='<?php echo $user->id;?>'<?php echo (isset ($posts['user_id']) ? $posts['user_id'] : User::current ()->id) == $user->id ? ' selected': '';?>><?php echo $user->name;?></option>
      <?php }
          }?>
        </select>
      </div>
    </div>

    <div class='row n2'>
      <label>* 聯絡人</label>
      <div>
        <select name='customer_id'>
          <option value='0' selected>請選擇聯絡人</option>
    <?php if ($companies = CustomerCompany::all (array ('select' => 'id, name'))) {
            foreach ($companies as $company) { ?>
              <optgroup label='<?php echo $company->name;?>'>
          <?php if ($company->customers) {
                  foreach ($company->customers as $customer) { ?>
                    <option value='<?php echo $customer->id;?>'<?php echo (isset ($posts['customer_id']) ? $posts['customer_id'] : '0') == $customer->id ? ' selected': '';?>><?php echo $customer->name;?></option>
            <?php }
                } ?>
              </optgroup>
      <?php }
          }
          if ($customers = Customer::find ('all', array ('select' => 'id, name', 'conditions' => array ('customer_company_id = 0')))) { ?>
            <optgroup label='其他'>
        <?php foreach ($customers as $customer) { ?>
                <option value='<?php echo $customer->id;?>'<?php echo (isset ($posts['customer_id']) ? $posts['customer_id'] : '0') == $customer->id ? ' selected': '';?>><?php echo $customer->name;?></option>
        <?php } ?>
            </optgroup>
      <?php } ?>
        </select>
      </div>
    </div>

    <div class='row n2'>
      <label>* 分類</label>
      <div>
        <select name='invoice_tag_id'>
          <option value='0' selected>請選擇分類</option>
    <?php if ($tags = InvoiceTag::all (array ('select' => 'id, name'))) {
            foreach ($tags as $tag) { ?>
              <option value='<?php echo $tag->id;?>'<?php echo (isset ($posts['invoice_tag_id']) ? $posts['invoice_tag_id'] : '0') == $tag->id ? ' selected': '';?>><?php echo $tag->name;?></option>
      <?php }
          }?>
        </select>
      </div>
    </div>


    <div class='row n2'>
      <label>* 專案名稱</label>
      <div>
        <input type='text' name='name' value='<?php echo isset ($posts['name']) ? $posts['name'] : '';?>' placeholder='請輸入專案名稱..' maxlength='200' pattern='.{1,200}' required title='輸入專案名稱!' autofocus />
      </div>
    </div>



    <div class='row n2'>
      <label>數量</label>
      <div>
        <input type='number' name='quantity' id='quantity' value='<?php echo isset ($posts['quantity']) ? $posts['quantity'] : '';?>' placeholder='請輸入數量..' />
      </div>
    </div>

    <div class='row n2'>
      <label>單價</label>
      <div>
        <input type='number' name='single_money' id='single_money' value='<?php echo isset ($posts['single_money']) ? $posts['single_money'] : '';?>' placeholder='請輸入單價..' />
      </div>
    </div>

    <div class='row n2'>
      <label>* 總金額</label>
      <div>
        <input type='number' name='all_money' id='all_money' value='<?php echo isset ($posts['all_money']) ? $posts['all_money'] : '';?>' placeholder='請輸入總金額..' maxlength='200' pattern='.{1,200}' required title='輸入總金額!' />
      </div>
    </div>

    <div class='row n2'>
      <label>備註</label>
      <div>
        <input type='text' name='memo' value='<?php echo isset ($posts['memo']) ? $posts['memo'] : '';?>' placeholder='請輸入備註..' maxlength='200' />
      </div>
    </div>

    <div class='row n2'>
      <label>結案日期</label>
      <div>
        <input type='date' name='closing_at' value='<?php echo isset ($posts['closing_at']) ? $posts['closing_at'] : '';?>' placeholder='請輸入結案日期..' maxlength='200' />
      </div>
    </div>

    <div class='btns'>
      <div class='row n2'>
        <label></label>
        <div>
          <button type='reset'>取消</button>
          <button type='submit'>送出</button>
        </div>
      </div>
    </div>
  </form>
</div>
