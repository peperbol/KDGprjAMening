﻿using UnityEngine;
using System.Collections;
using UnityEngine.UI;
using System.Collections.Generic;
using System.Linq;

public class LoadQuestion : MonoBehaviour {

    public Text questionText;
    public Text projectText;
    public Queue<Question> questions = new Queue<Question>();
    public Material Image;
    public List<string> ids;
    public Question lastQuestion;
    void Start () {
        QueueIds();
    }
    void QueueIds() {
        foreach (var id in ids)
        {
            try
            {
                questions.Enqueue(new Question(id));
            }
            catch (System.IO.FileNotFoundException) { Debug.LogWarning("Did not find file of id " + id); }
        }
       // ids.Clear();
    }

    public void NextQuestion(Text left, Text right, Material mat) {
        if (questions.Count <= 0) QueueIds();
        lastQuestion = questions.Dequeue();
        left.text = lastQuestion.leftText;
        right.text = lastQuestion.rightText;
        if (lastQuestion.fullPicture)
        {
            mat.SetTexture("_MainTex1", lastQuestion.MainImage);
        }
        else
        {
            mat.SetTexture("_MainTex1", lastQuestion.LeftImage);
            mat.SetTexture("_MainTex2", lastQuestion.RightImage);
        }
    }
    public void SetTitle() {
        questionText.text = lastQuestion.questionText;
        projectText.text = lastQuestion.projectText.ToUpper();
    }

	void Update () {
	
	}
}
