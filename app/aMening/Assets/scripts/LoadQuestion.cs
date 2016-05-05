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
    public List<string> ids;
    public Question lastQuestion;
    SwipeInput si;
    void Awake()
    {
        si = FindObjectOfType<SwipeInput>();
    }
    public void Add(string id)
    {
        ids.Add(id);
        si.enabled = true;
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
    void loadscreen()
    {
        lastQuestion = null;
        si.enabled = false;
    }
    public bool NextQuestion(Text left, Text right, Material mat)
    {
        if (questions.Count <= 0) QueueIds();
        if (questions.Count <= 0)
        {
            loadscreen();
            return false;
        }
        lastQuestion = questions.Dequeue();
        Debug.Log(questions.Count);
        left.text = lastQuestion.leftText;
        right.text = lastQuestion.rightText;
        if (lastQuestion.fullPicture)
        {
            mat.SetTexture("_MainTex1", Texture2D.whiteTexture);
            lastQuestion.GetMainImage(this, e => mat.SetTexture("_MainTex1", e));
        }
        else
        {
            mat.SetTexture("_MainTex1", Texture2D.whiteTexture);
            mat.SetTexture("_MainTex2", Texture2D.whiteTexture);
            lastQuestion.GetLeftImage( this, e=> mat.SetTexture("_MainTex1", e) );
            lastQuestion.GetRightImage(this, e => mat.SetTexture("_MainTex2", e));
        }
        return true;
    }
    public void SetTitle()
    {
        if (lastQuestion != null)
        {
            questionText.text = lastQuestion.questionText;
            projectText.text = lastQuestion.projectText.ToUpper();
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
