using UnityEngine;
using System.Collections;
using UnityEngine.UI;
using System.Collections.Generic;
using System.Linq;

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
