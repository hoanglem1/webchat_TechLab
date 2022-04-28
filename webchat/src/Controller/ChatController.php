<?php
// src/Controller/ArticlesController.php

namespace App\Controller;

use Cake\I18n\Time;

class ChatController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('T_feed');
        $this->loadComponent('Paginator');
        $this->viewBuilder()->setLayout('chat');
        $this->loadComponent('Flash');
    }

    public function index()
    {
        $session = $this->request->getSession();
        $email = $session->read('email');
        $name = $session->read('name');
        $user_id = $session->read('user_id');
        if (!$email) {
            return $this->redirect(['controller' => 'user', 'action' => 'login']);
        }
        $t_feed =  $this->T_feed->find();
        $this->set(compact('t_feed'));
        $this->set(compact('name'));
        $this->set(compact('user_id'));
    }

    public function feed()
    {
        $session = $this->request->getSession();
        $email = $session->read('email');
        $name = $session->read('name');
        $user_id = $session->read('user_id');
        if (!$email) {
            return $this->redirect(['controller' => 'user', 'action' => 'login']);
        }
        $t_feed_new = $this->T_feed->newEmptyEntity();
        if ($this->request->is('post')) {
            $t_feed_new = $this->T_feed->patchEntity($t_feed_new, $this->request->getData());
            $session = $this->request->getSession();
            $image = $this->request->getData('image');
            $video = $this->request->getData('video');
            $image_name = $image->getclientFilename();
            $video_name = $video->getclientFilename();
        if ($t_feed_new->getErrors()) {
            return $this->redirect(['action' => 'index']);
        }
        $t_feed_new->user_id = $session->read('user_id');
        $t_feed_new->name = $session->read('name');
            //Save Image
        if ($image_name) {
            $t_feed_new->image_file_name = 'upload/' . $image_name;
            if (!is_dir(WWW_ROOT . 'img' . DS . 'upload')) {
                mkdir(WWW_ROOT . 'img' . DS . 'upload', 755);
            }
            $targetPath = WWW_ROOT . 'img' . DS . 'upload' . DS . $image_name;
            $image->moveTo($targetPath);
        }
            //Save Video
        if ($video_name) {
            $t_feed_new->image_file_name = 'video/' . $video_name;
            if (!is_dir(WWW_ROOT . 'files' . DS . 'video')) {
                mkdir(WWW_ROOT . 'files' . DS . 'video', 755);
            }
            $targetPath = WWW_ROOT . 'files' . DS . 'video' . DS . $video_name;
            $video->moveTo($targetPath);
        }
        //Save Feed
        if ($this->T_feed->save($t_feed_new))
            return $this->redirect(['action' => 'index']);
    }
        $this->set('t_feed', $t_feed_new);
    }

    public function edit($id)
    {
        $session = $this->request->getSession();
        $email = $session->read('email');
        $name = $session->read('name');
        $user_id = $session->read('user_id');
        $t_feed = $this->T_feed
            ->findById($id)
            ->firstOrFail();
        if (!$email || $user_id != $t_feed->user_id) {
            return $this->redirect(['controller' => 'user', 'action' => 'login']);
        }
        $this->set(compact('name'));
        $this->set(compact('t_feed'));
        if ($this->request->is(['post', 'put'])) {
            $this->T_feed->patchEntity($t_feed, $this->request->getData());
            $image = $this->request->getData('image');
            $video = $this->request->getData('video');
            $image_name = $image->getclientFilename();
            $video_name = $video->getclientFilename();
            if ($image_name) {
                $t_feed->image_file_name = 'upload/' . $image_name;

                if (!is_dir(WWW_ROOT . 'img' . DS . 'upload')) {
                    mkdir(WWW_ROOT . 'img' . DS . 'upload', 755);
                }
                $targetPath = WWW_ROOT . 'img' . DS . 'upload' . DS . $image_name;
                $image->moveTo($targetPath);
            }
            if ($video_name) {
                $t_feed->image_file_name = 'video/' . $video_name;
                if (!is_dir(WWW_ROOT . 'files' . DS . 'video')) {
                    mkdir(WWW_ROOT . 'files' . DS . 'video', 755);
                }
                $targetPath = WWW_ROOT . 'files' . DS . 'video' . DS . $video_name;
                $video->moveTo($targetPath);
            }
            if ($this->T_feed->save($t_feed)) {
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->set('t_feed', $t_feed);
    }

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $t_feed = $this->T_feed->findById($id)->firstOrFail();
        if ($this->T_feed->delete($t_feed)) {
            return $this->redirect(['action' => 'index']);
        }
    }
}
