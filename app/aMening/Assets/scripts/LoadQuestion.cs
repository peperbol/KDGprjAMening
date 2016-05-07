using UnityEngine;
using System.Collections;
using UnityEngine.UI;
using System.Collections.Generic;
using System.Linq;
using System;

public class LoadQuestion : MonoBehaviour
{

    public Text questionText;
    public Text projectText;
    public Queue<Question> questions = new Queue<Question>();
    public Material Image;
    public OverlaySlider loadingScreen;
    public List<string> ids;
    SwipeInput si;
    
    void Awake()
    {
        si = FindObjectOfType<SwipeInput>();
    }
    public void Add(string id)
    {

        ids.Add(id);
        si.fillQueue();
    }
    public void Answer(bool isLeft)
    {

    }
    void QueueIds()
    {
        foreach (var id in ids)
        {
            try
            {
                questions.Enqueue(new Question(id));
            }
            catch (System.IO.FileNotFoundException) { Debug.LogWarning("Did not find file of id " + id); }
        }

        ids.Clear();
    }
    public bool IsQuestionAvailable { get {
            if (questions.Count <= 0) QueueIds();
            return questions.Count > 0;
        } }
    public Question NextQuestion(Text left, Text right, Material mat)
    {
        if (!IsQuestionAvailable)
        {
            return null;
        }
        Question lastQuestion = questions.Dequeue();

        left.text = lastQuestion.leftText;
        right.text = lastQuestion.rightText;
        if (lastQuestion.fullPicture)
        {
            mat.SetTexture("_MainTex1", Texture2D.whiteTexture);
            lastQuestion.GetMainImage(this, e => {
                mat.SetTexture("_MainTex1", e);
                loadingScreen.visisble = false;
                });
        }
        else
        {
            mat.SetTexture("_MainTex1", Texture2D.whiteTexture);
            mat.SetTexture("_MainTex2", Texture2D.whiteTexture);
            lastQuestion.GetLeftImage( this, e=> mat.SetTexture("_MainTex1", e) );
            lastQuestion.GetRightImage(this, e => {
                mat.SetTexture("_MainTex2", e);
                loadingScreen.visisble = false;
            });
        }
        return lastQuestion;
    }
    public void SetTitle(Question q)
    {
        if (q != null)
        {
            questionText.text = q.questionText;
            projectText.text = q.projectText.ToUpper();
        }
        else
        {
            questionText.text = projectText.text = "";
        }
    }

    void Update()
    {

    }
}
