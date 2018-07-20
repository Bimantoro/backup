<rss version="2.0">
<channel>
  <title><?php echo $feed_name ?></title>
  <link><?php echo $feed_url ?></link>
  <description><?php echo $feed_description ?></description>
   <?php foreach($pengumuman->result() as $p): ?>  
			  <item>
			  <title><?php echo $p->judul ?></title>
			  <link><?php echo site_url('page/pengumuman/detail/' . $p->id_pengumuman) ?> </link>
			   <pubdate><?php echo $p->tgl_posting." ".$p->jam_posting ?></pubdate> 
			
			  </item>
						 
                 
           <?php endforeach; ?>  
  
</channel>
</rss> 