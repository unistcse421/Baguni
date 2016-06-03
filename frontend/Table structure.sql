
--
-- 데이터베이스: `baguni2`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `item`
--

CREATE TABLE `item` (
  `item_id` int(11) NOT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `status` enum('reg','zzim','in_progress','in_baguni','done') NOT NULL,
  `title` text NOT NULL,
  `contents` text NOT NULL,
  `reg_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `jjim_time` timestamp NULL DEFAULT NULL,
  `In_progress_time` timestamp NULL DEFAULT NULL,
  `In_baguni_time` timestamp NULL DEFAULT NULL,
  `done_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 테이블 구조 `item_comment`
--

CREATE TABLE `item_comment` (
  `ic_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `comment` text,
  `comment_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 테이블 구조 `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `id` text NOT NULL,
  `pw` text NOT NULL,
  `phone` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 테이블 구조 `user_account`
--

CREATE TABLE `user_account` (
  `uid` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `money_delta` int(11) NOT NULL,
  `money_remain` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `buyer_id` (`buyer_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- 테이블의 인덱스 `item_comment`
--
ALTER TABLE `item_comment`
  ADD PRIMARY KEY (`ic_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `uid` (`uid`);

--
-- 테이블의 인덱스 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- 테이블의 인덱스 `user_account`
--
ALTER TABLE `user_account`
  ADD KEY `uid` (`uid`),
  ADD KEY `item_id` (`item_id`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 테이블의 AUTO_INCREMENT `item_comment`
--
ALTER TABLE `item_comment`
  MODIFY `ic_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 테이블의 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 덤프된 테이블의 제약사항
--

--
-- 테이블의 제약사항 `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `user` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `user` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 테이블의 제약사항 `item_comment`
--
ALTER TABLE `item_comment`
  ADD CONSTRAINT `item_comment_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `item_comment_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 테이블의 제약사항 `user_account`
--
ALTER TABLE `user_account`
  ADD CONSTRAINT `user_account_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`),
  ADD CONSTRAINT `user_account_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
